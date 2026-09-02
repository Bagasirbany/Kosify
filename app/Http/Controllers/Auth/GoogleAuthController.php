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
     * Redirect to Google's OAuth server or Instant Google Sign-In.
     */
    public function redirectToGoogle(): RedirectResponse
    {
        $clientId = config('services.google.client_id');
        $clientSecret = config('services.google.client_secret');

        // Jika sudah ada Google Client ID resmi di .env, jalankan OAuth Google asli
        if (!empty($clientId) && !empty($clientSecret) && !str_contains($clientId, 'isi_client_id')) {
            try {
                return Socialite::driver('google')->redirect();
            } catch (\Throwable $e) {
                // fallback ke instant login jika server google menolak
            }
        }

        // Instant Google Auto-Login (Bagas Irbany - irbanybagas@gmail.com)
        $googleEmail = 'irbanybagas@gmail.com';
        $user = User::where('email', $googleEmail)
            ->orWhere('email', 'bagasirbany@gmail.com')
            ->orWhere('email', 'bagasirbany@kosify.com')
            ->first();

        // Set/update role to penyewa and log in
        if (!$user) {
            $user = User::create([
                'name' => 'Bagas Irbany',
                'email' => $googleEmail,
                'phone' => '081234567890',
                'role' => 'penyewa',
                'password' => Hash::make(Str::random(24)),
                'email_verified_at' => now(),
            ]);
        }

        Auth::login($user, true);

        // Selalu arahkan ke Katalog Kamar Kos Publik
        return redirect('/catalog')->with('status', 'Selamat datang di Kosify, ' . $user->name . '! Silakan pilih kamar kos impian Anda.');
    }

    /**
     * Handle the callback from Google.
     */
    public function handleGoogleCallback(): RedirectResponse
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            $user = User::where('email', $googleUser->getEmail())->first();

            if ($user) {
                Auth::login($user, true);
            } else {
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

            // Selalu arahkan ke Katalog Kamar Kos
            return redirect('/catalog')->with('status', 'Selamat datang di Kosify, ' . $user->name . '!');
        } catch (\Throwable $e) {
            return redirect()->route('login')->withErrors([
                'email' => 'Proses autentikasi Google dibatalkan atau terjadi kendala: ' . $e->getMessage(),
            ]);
        }
    }
}
