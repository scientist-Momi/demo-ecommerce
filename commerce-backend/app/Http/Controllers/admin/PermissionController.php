<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\Permission;
use App\Models\User;
use App\Services\PermissionService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PermissionController extends Controller
{
    protected $permissionService;

    public function __construct(PermissionService $permissionService)
    {
        $this->permissionService = $permissionService;
    }

    // public function index(User $user)
    // {
    //     $permissions = $user->permissions()->with('page')->get();
    //     return response()->json($permissions);
    // }

    public function index(User $user)
    {
        // Retrieve pages the user has permissions for, including related page details
        $permissions = $user->permissions()->with('page')->get();

        // Retrieve all pages that the user does not have permissions for
        $userPageIds = $permissions->pluck('page_id')->toArray();
        $pagesWithoutPermissions = Page::whereNotIn('id', $userPageIds)->get();

        return response()->json([
            'permitted' => $permissions,
            'not_permitted' => $pagesWithoutPermissions
        ]);
    }

    public function update(Request $request, User $user)
    {
        // Validate the request to ensure 'pages' is provided and is an array
        $validator = Validator::make($request->all(), [
            'pages' => 'array',
            'permissions' => 'array'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }
        $pageIdsFromPermissions = collect($request->input('permissions'))
            ->pluck('page_id')
            ->toArray();
        // Get the array of page IDs from the request

        $pageIds = !empty($pageIdsFromPermissions) ? $pageIdsFromPermissions : $request->input('pages');
        $updatedPermissions = [];

        foreach ($pageIds as $pageId) {
            try {
                // Find the page or fail if it doesn't exist
                $page = Page::findOrFail($pageId);

                $permissionData = collect($request->input('permissions', []))
                ->firstWhere('page_id', $pageId);

                // Create a permission request with default values
                $permissionRequest = new Request([
                    'can_view' => $permissionData['can_view'] ?? true,
                    'can_add' => $permissionData['can_add'] ?? false,
                    'can_edit' => $permissionData['can_edit'] ?? false,
                    'can_delete' => $permissionData['can_delete'] ?? false,
                ]);

                // Update permission using the service and collect the response
                $permission = $this->permissionService->updatePermission($permissionRequest, $user, $page);

                // Add the updated permission to the array
                $updatedPermissions[] = $permission;
            } catch (ModelNotFoundException $e) {
                return response()->json(['error' => "Page with ID $pageId not found."], 404);
            } catch (\Exception $e) {
                return response()->json(['error' => 'An error occurred while updating permissions.'], 500);
            }
        }

        // Return the list of updated permissions
        return response()->json(['updated_permissions' => $updatedPermissions]);
    }


    public function destroy(User $user, Page $page)
    {
        $permission = Permission::where('user_id', $user->user_id)->where('page_id', $page->id)->first();
        if ($permission) {
            $permission->delete();
            return response()->json(['message' => 'Permission deleted successfully']);
        }
        return response()->json(['message' => 'Permission not found'], 404);
    }
}
