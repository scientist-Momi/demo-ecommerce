<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\admin\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\Admin;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Str;
use App\Models\LoginSession;
use App\Models\Page;
use App\Models\Permission;
use App\Services\PermissionService;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{
    protected $permissionService;

    public function __construct(PermissionService $permissionService)
    {
        $this->permissionService = $permissionService;
    }

    public function createAccount(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:255',
            'password' => 'required|string|min:8',
            'pages' => 'required|array',
            'created_by' => 'nullable|exists:users,id',
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
                'isAdmin' => 1,
            ]);

            $userLoggedIn = Auth::user();

            $admin = Admin::create([
                'user_id' => $user->user_id,
                'role' => 'SUB ADMIN',
                'created_by' => $userLoggedIn->user_id,
            ]);

            $pageIds = $request->input('pages');
            foreach ($pageIds as $pageId) {
                $page = Page::findOrFail($pageId);
                $permissionRequest = new Request([
                    'can_view' => true,
                    'can_add' => false,
                    'can_edit' => false,
                    'can_delete' => false
                ]);
                $this->permissionService->updatePermission($permissionRequest, $user, $page);
            }

            DB::commit();

            return response()->json([
                'message' => 'Account created successfully',
                // 'token' => AuthController::issueToken($request->email, $user),
            ], 201);
        } catch (Exception $e) {
            Log::error('Admin account creation failed', ['error' => $e->getMessage()]);

            return response()->json([
                'error' => 'Admin account could not be created',
                'message' => $e->getMessage(),
            ], 500);
        }
    }


    public function authenticate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();

            $user->load('admin.createdBy');

            $loginSession = new LoginSession([
                'user_id' => Auth::id(),
                'location' => $this->getLocationFromIP($request->ip()),
                'device' => $request->header('User-Agent'),
                'ip_address' => $request->ip(),
                'login_time' => now(),
                'is_current_session' => true,
            ]);

            if ($loginSession->save()) {
                return response()->json([
                    'message' => 'Authentication successfull',
                    'user' => new UserResource($user),
                    'token' => AuthController::issueToken($request->email, $user),
                    // 'location' => $this->getLocationFromIP($request->ip()),
                    // 'device' => $request->header('User-Agent'),
                    // 'ip_address' => $request->ip(),
                    // 'login_time' => now(),
                ], 200);
            }

            return response()->json(['error' => 'Something went wrong'], 401);
        }

        return response()->json(['error' => 'Invalid credentials'], 401);
    }

    private function issueToken($userEmail, $user)
    {
        return $user->createToken($userEmail)->plainTextToken;
    }

    public function getUser(Request $request)
    {
        $user = Auth::user();

        $user->load('admin.createdBy');

        return new UserResource($user);
    }

    private function getLocationFromIP($ip)
    {
        // Call the ipinfo.io API
        $response = Http::get("http://ipinfo.io/{$ip}/json");

        if ($response->successful()) {
            $data = $response->json();

            // Example response parsing
            if (isset($data['city']) && isset($data['country'])) {
                return $data['city'] . ', ' . $data['country'];
            }
        }

        return null; // Return null if location can't be determined
    }
}
