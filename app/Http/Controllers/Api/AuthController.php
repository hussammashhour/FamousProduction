<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    use ApiResponseTrait;

    /**
     * Login user and return token
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
            'device_name' => 'nullable|string',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        // Revoke existing tokens for this device (optional)
        if ($request->device_name) {
            $user->tokens()->where('name', $request->device_name)->delete();
        }

        // Create new token
        $token = $user->createToken($request->device_name ?? 'api-token')->plainTextToken;

        return $this->successResponse([
            'user' => $user->load('roles'),
            'token' => $token,
            'token_type' => 'Bearer',
        ], 'Login successful');
    }

    /**
     * Logout user and revoke token
     */
    public function logout(Request $request)
    {
        // Revoke the current token
        $request->user()->currentAccessToken()->delete();

        return $this->successResponse([], 'Logged out successfully');
    }

    /**
     * Get current authenticated user
     */
    public function me(Request $request)
    {
        return $this->successResponse([
            'user' => $request->user()->load('roles'),
        ], 'User retrieved successfully');
    }

    /**
     * Refresh token (optional - create new token and revoke old one)
     */
    public function refresh(Request $request)
    {
        $user = $request->user();

        // Revoke current token
        $user->currentAccessToken()->delete();

        // Create new token
        $token = $user->createToken('api-token')->plainTextToken;

        return $this->successResponse([
            'user' => $user->load('roles'),
            'token' => $token,
            'token_type' => 'Bearer',
        ], 'Token refreshed successfully');
    }

    /**
     * Revoke all tokens for the user
     */
    public function logoutAll(Request $request)
    {
        $request->user()->tokens()->delete();

        return $this->successResponse([], 'All sessions logged out successfully');
    }
}
