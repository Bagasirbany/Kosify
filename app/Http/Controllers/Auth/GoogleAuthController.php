<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    /**
     * Redirect ke server Google resmi (jika ada Client ID di .env)
     * atau buka layar Google Account Chooser persis seperti tampilan Google.
     */
    public function redirectToGoogle()
    {
        $clientId = config('services.google.client_id');
        $clientSecret = config('services.google.client_secret');

        // Jika user sudah memasukkan Client ID & Secret resmi di .env, jalankan OAuth Google asli
        if (!empty($clientId) && !empty($clientSecret) && !str_contains($clientId, 'isi_client_id')) {
            try {
                return Socialite::driver('google')->redirect();
            } catch (\Throwable $e) {
                // jika gagal, tampilkan layar chooser
            }
        }

        // Tampilkan layar Google Account Chooser (Dark Theme persis Google)
        return view('auth.google_chooser');
    }

    /**
     * Login instan saat akun dipilih dari Google Account Chooser.
     */
    public function selectAccount(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => 'required|email',
            'name' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => '-',
                'role' => 'penyewa',
                'password' => Hash::make(Str::random(24)),
                'email_verified_at' => now(),
            ]);
        }

        Auth::login($user, true);

        return redirect('/catalog')->with('status', 'Berhasil masuk dengan Akun Google (' . $user->name . ' - ' . $user->email . ')! 🎉');
    }

    /**
     * Menerima callback data akun dari Google setelah user memilih akun (OAuth asli).
     */
    public function handleGoogleCallback(): RedirectResponse
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            $user = User::where('email', $googleUser->getEmail())->first();

            if (!$user) {
                $user = User::create([
                    'name' => $googleUser->getName() ?? $googleUser->getNickname() ?? 'Pengguna Google',
                    'email' => $googleUser->getEmail(),
                    'phone' => '-',
                    'role' => 'penyewa',
                    'password' => Hash::make(Str::random(24)),
                    'email_verified_at' => now(),
                ]);
            }

            Auth::login($user, true);

            return redirect('/catalog')->with('status', 'Selamat datang di Kosify, ' . $user->name . '!');
        } catch (\Throwable $e) {
            return redirect()->route('login')->withErrors([
                'email' => 'Gagal login via Google: ' . $e->getMessage(),
            ]);
        }
    }
}
