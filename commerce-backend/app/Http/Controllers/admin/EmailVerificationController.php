<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\VerifyToken;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class EmailVerificationController extends Controller
{
    public function sendVerificationEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }
        $token = Str::random(6);

        // Store the token in the database
        $token = VerifyToken::updateOrCreate(
            ['email' => $request->email],
            ['token' => $token]
        );

        if($token){
                    // Send the verification email
        // Mail::raw("Your verification token is: $token", function ($message) use ($email) {
        //     $message->to($email)
        //         ->subject('Email Verification');
        // });
            return response()->json([
                'message' => 'Verification email sent',
                'token' => $token
            ], 200);
        }

        return response()->json(['error' => 'Something went wrong. Please try again'], 401);

    }

    public function verifyToken(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'token' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $email = $request->email;
        $token = $request->token;

        $verificationToken = VerifyToken::where('email', $email)->first();

        if ($verificationToken && $verificationToken->token === $token) {
            // Token is valid, delete it
            $verificationToken->delete();
            return response()->json(['message' => 'Token verified'], 200);
        }

        return response()->json(['message' => 'Invalid token'], 400);
    }
}
