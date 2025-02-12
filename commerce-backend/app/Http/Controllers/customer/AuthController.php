<?php

namespace App\Http\Controllers\customer;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function createAccount(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:255',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        DB::beginTransaction();
        try {
            $user = User::create([
                'user_id' => Str::uuid()->toString(),
                'firstname' => $request->firstname,
                'lastname' => $request->lastname,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => bcrypt($request->password),
                'isAdmin' => 0,
            ]);

            $customer = Customer::create([
                'user_id' => $user->user_id,
            ]);

            DB::commit();

            return response()->json([
                'message' => 'Account created successfully',
                // 'token' => AuthController::issueToken($request->email, $user),
            ], 201);
        } catch (Exception $e) {
            Log::error('Customer account creation failed', ['error' => $e->getMessage()]);

            return response()->json([
                'error' => 'Admin account could not be created',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
