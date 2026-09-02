<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    /**
     * Redirect to Google's OAuth server.
     */
    public function redirectToGoogle(): RedirectResponse
    {
        try {
            return Socialite::driver('google')->redirect();
        } catch (\Throwable $e) {
            return redirect()->route('login')->withErrors([
                'email' => 'Gagal membuka login Google: ' . $e->getMessage(),
            ]);
        }
    }

    /**
     * Handle the callback from Google.
     */
    public function handleGoogleCallback(): RedirectResponse
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            // Find existing user by google_id or email
            $user = User::where('email', $googleUser->getEmail())->first();

            if ($user) {
                // Update avatar if not set
                Auth::login($user, true);
            } else {
                // Register new user automatically
                $user = User::create([
                    'name' => $googleUser->getName() ?? $googleUser->getNickname() ?? 'Pengguna Google',
                    'email' => $googleUser->getEmail(),
                    'phone' => '-',
                    'role' => 'penyewa',
                    'password' => Hash::make(Str::random(24)),
                    'email_verified_at' => now(),
                ]);

                Auth::login($user, true);
            }

            if ($user->role === 'admin') {
                return redirect()->intended('/dashboard');
            }

            return redirect()->intended('/catalog');
        } catch (\Throwable $e) {
            return redirect()->route('login')->withErrors([
                'email' => 'Proses autentikasi Google dibatalkan atau terjadi kendala: ' . $e->getMessage(),
            ]);
        }
    }
}
