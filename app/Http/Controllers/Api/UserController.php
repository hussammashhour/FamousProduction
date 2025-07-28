<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Resources\UserResource;
use App\Http\Resources\UserCollection;
use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;
use Illuminate\Support\Facades\Hash;
use App\Policies\UserPolicy;
use App\Providers\AuthServiceProvider;


class UserController extends Controller
{
    use ApiResponseTrait;

    /**
     * Display a listing of the users.
     */
    public function index(): \Illuminate\Http\JsonResponse
    {
        $users = User::latest()->paginate(10);
        return $this->successResponse(
            new UserCollection($users),
            'User list retrieved successfully.'
        );
    }

    /**
     * Store a newly created user in storage.
     */
        public function store(StoreUserRequest $request): \Illuminate\Http\JsonResponse
        {
            $validated = $request->validated();
            $validated['password'] = Hash::make($validated['password']);

            $user = User::create($validated);

            $token = $user->createToken('auth_token')->plainTextToken;

            return $this->successResponse(
                [
                    'user' => new UserResource($user),
                    'token' => $token,
                ],
                'User registered successfully.',
                201
            );
        }

    /**
     * Display the specified user.
     */
    public function show(User $user): \Illuminate\Http\JsonResponse
    {
        return $this->successResponse(
            new UserResource($user),
            'User retrieved successfully.'
        );
    }

    /**
     * Update the specified user in storage.
     */
    public function update(StoreUserRequest $request, User $user): \Illuminate\Http\JsonResponse
    {
         $this->authorize('update', $user);
        $validated = $request->validated();

        // Only hash password if provided
        if (isset($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        }

        $user->update($validated);

        return $this->successResponse(
            new UserResource($user),
            'User updated successfully.'
        );
    }

    /**
     * Remove the specified user from storage (soft delete).
     */
    public function destroy(User $user): \Illuminate\Http\JsonResponse
    {
        $user->delete();

        return $this->successResponse(
            [],
            'User deleted successfully.'
        );
    }
}
