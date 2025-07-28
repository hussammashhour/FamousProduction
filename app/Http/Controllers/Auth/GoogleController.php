<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Exception;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            // Split the name into first and last name
            $nameParts = explode(' ', $googleUser->getName(), 2);
            $firstName = $nameParts[0] ?? '';
            $lastName = $nameParts[1] ?? '';

            // Find or create user
            $user = User::firstOrCreate(
                ['email' => $googleUser->getEmail()],
                [
                    'first_name' => $firstName,
                    'last_name' => $lastName,
                    'google_id' => $googleUser->getId(),
                    'email_verified_at' => now(), // Google users are pre-verified
                    'password' => bcrypt(Str::random(16)), // Random password for Google users
                ]
            );

            // Update google_id if user exists but doesn't have it
            if (!$user->google_id) {
                $user->update(['google_id' => $googleUser->getId()]);
            }

            Auth::login($user);

            return redirect('/dashboard');

        } catch (Exception $e) {
            return redirect('/login')->with('error', 'Google login failed. Please try again.');
        }
    }
}
