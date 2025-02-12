<?php

namespace App\Services;

use App\Models\Permission;
use App\Models\User;
use App\Models\Page;
use Illuminate\Http\Request;

class PermissionService
{
    public function updatePermission(Request $request, User $user, Page $page)
    {
        $permission = Permission::updateOrCreate(
            ['user_id' => $user->user_id, 'page_id' => $page->id],
            [
                'can_view' => $request->input('can_view', true),
                'can_add' => $request->input('can_add', false),
                'can_edit' => $request->input('can_edit', false),
                'can_delete' => $request->input('can_delete', false)
            ]
        );

        return $permission;
    }
}
