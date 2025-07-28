<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use App\Traits\ApiResponseTrait;

class UserRoleController extends Controller
{
    use ApiResponseTrait;

    public function assign(User $user, Role $role)
    {
        if (!$user->roles()->where('role_id', $role->id)->exists()) {
            $user->roles()->attach($role->id);
        }

        return $this->successResponse([], 'Role assigned successfully.');
    }

    public function remove(User $user, Role $role)
    {
        $user->roles()->detach($role->id);

        return $this->successResponse([], 'Role removed successfully.');
    }

    public function syncRoles(\Illuminate\Http\Request $request, User $user)
    {
        $request->validate(['roles' => 'array']);
        $user->roles()->sync($request->input('roles', []));
        return $this->successResponse([], 'Roles synced successfully.');
    }
}
