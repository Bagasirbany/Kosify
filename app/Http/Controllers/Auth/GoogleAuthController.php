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
        $clientId = config('services.google.client_id');
        $clientSecret = config('services.google.client_secret');

        if (empty($clientId) || empty($clientSecret) || $clientId === 'isi_client_id_disini') {
            return redirect()->route('login')->with(
                'status',
                'Untuk mengaktifkan login Google, isi GOOGLE_CLIENT_ID & GOOGLE_CLIENT_SECRET di file .env Anda terlebih dahulu.'
            );
        }

        try {
            return Socialite::driver('google')->redirect();
        } catch (\Throwable $e) {
            return redirect()->route('login')->withErrors([
                'email' => 'Gagal menghubungkan ke server Google: ' . $e->getMessage(),
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
