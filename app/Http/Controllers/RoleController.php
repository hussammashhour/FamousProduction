<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Resources\RoleResource;
use App\Traits\ApiResponseTrait;

class RoleController extends Controller
{
    use ApiResponseTrait;

    public function index()
    {
        $roles = Role::all();
        return $this->successResponse(RoleResource::collection($roles), 'Roles retrieved successfully');
    }

    public function store(StoreRoleRequest $request)
    {
        $role = Role::create($request->validated());
        return $this->successResponse(new RoleResource($role), 'Role created successfully', 201);
    }

    public function show(Role $role)
    {
        return $this->successResponse(new RoleResource($role), 'Role retrieved successfully');
    }

    public function destroy(Role $role)
    {
        $role->delete();
        return $this->successResponse([], 'Role deleted successfully');
    }
}
