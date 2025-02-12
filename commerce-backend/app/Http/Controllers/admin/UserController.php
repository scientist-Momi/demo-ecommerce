<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\CustomerResource;
use App\Http\Resources\UserResource;
use App\Models\Address;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{

    public function getCustomers()
    {
        // Get request parameters
        $search = request('search', '');
        $isLocked = request('isLocked', null);
        $authUserId = Auth::user()->user_id;

        // Query to get users who are not admins and exclude the authenticated user
        $query = User::with('customer')  // Load related customer data
        ->where('isAdmin', 0)
        ->where('user_id', '!=', $authUserId)
            ->when($search, function ($query, $search) {
                // Apply search filter
                $query->where(function ($query) use ($search) {
                    $query->where('firstname', 'like', "%{$search}%")
                    ->orWhere('lastname', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->when(isset($isLocked), function ($query) use ($isLocked) {
                // Apply the is_locked filter only if it is explicitly set (0 or 1)
                $query->whereHas('customer', function ($query) use ($isLocked) {
                    $query->where('is_locked', $isLocked);
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);  // Pagination of 10 per page

        return CustomerResource::collection($query);
    }



    public function getAdminUsers()
    {
        // $perPage = request('per_page', 10);
        $search = request('search', '');
        $role = request('role', '');
        $authUserId = Auth::user()->user_id;
        // $sortField = request('sort_field', 'updated_at');
        // $sortDirection = request('sort_direction', 'desc');

        $query = User::with('admin.createdBy')
            ->where('isAdmin', 1)
            ->where('user_id', '!=', $authUserId)
            ->whereDoesntHave('admin', function ($query) {
                $query->where('role', 'super admin');
            })
            ->when($search, function ($query, $search) {
                $query->where(function ($query) use ($search) {
                    $query->where(
                        'firstname',
                        'like',
                        "%{$search}%"
                    )
                        ->orWhere('lastname', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->when($role, function ($query, $role) {
                $query->whereHas('admin', function ($query) use ($role) {
                    $query->where('role', $role);
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return UserResource::collection($query);
    }

    public function deleteUser($id)
    {
        // Check if the user is authorized to delete users
        if (!Auth::user()->isAdmin) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Find the user by ID and delete
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json(['message' => 'User deleted successfully']);
    }


    public function showUser($id)
    {
        // Fetch the user by ID with additional related data if needed (e.g., roles, posts, etc.)
        $user = User::with(['admin', 'address', 'loginSessions', 'logs'])->findOrFail($id);

        return response()->json($user);
    }

    public function updateUserPassword(Request $request, $id)
    {
        // Check if the user is authorized to update passwords
        if (!Auth::user()->isAdmin) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Validate the incoming request data
        $validatedData = $request->validate([
            'password' => 'required|string|min:8',
            'sendPasswordToUser' => 'sometimes|boolean'
        ]);

        // Find the user by ID
        $user = User::findOrFail($id);

        // Update the user's password
        $user->password = bcrypt($validatedData['password']);
        $savePassword = $user->save();

        if(!$savePassword){
            return response()->json(['message' => 'Something went wrong'], 400);
        }

        if ($request->has('sendPasswordToUser') && $request->sendPasswordToUser) {
            // Mail::to($user->email)->send(new PasswordUpdated($validatedData['password']));
            return response()->json(['message' => 'Password sent to user and saved'], 200);
        }

        return response()->json(['message' => 'Password saved without sending'], 200);
    }

    public function updateUser(Request $request, $id)
    {
        $validatedData = $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'postal_code' => 'required|string|max:20',
            'country' => 'required|string|max:255',
        ]);

        DB::beginTransaction();

        try {
            // Find user and update
            $user = User::findOrFail($id);
            $user->update([
                'firstname' => $validatedData['firstname'],
                'lastname' => $validatedData['lastname'],
                'phone' => $validatedData['phone'],
            ]);

            // Find or create address for the user and update
            $address = Address::firstOrNew(['user_id' => $user->user_id]);
            $address->fill([
                'address' => $validatedData['address'],
                'city' => $validatedData['city'],
                'state' => $validatedData['state'],
                'postal_code' => $validatedData['postal_code'],
                'country' => $validatedData['country'],
            ]);
            $address->save();

            DB::commit();

            return response()->json(['message' => 'User and Address updated successfully.'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'An error occurred while updating user information.'], 500);
        }
    }

}
