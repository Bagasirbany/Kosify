<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // Simpan preferensi 'Selalu ingat saya' & email pengguna selama 30 hari jika dicentang
        if ($request->boolean('remember')) {
            \Illuminate\Support\Facades\Cookie::queue('kosify_remember_email', $request->email, 60 * 24 * 30);
            \Illuminate\Support\Facades\Cookie::queue('kosify_remember_active', '1', 60 * 24 * 30);
        } else {
            \Illuminate\Support\Facades\Cookie::queue(\Illuminate\Support\Facades\Cookie::forget('kosify_remember_email'));
            \Illuminate\Support\Facades\Cookie::queue(\Illuminate\Support\Facades\Cookie::forget('kosify_remember_active'));
        }

        if (in_array(Auth::user()->role, ['admin', 'admin_web', 'pemilik', 'owner'])) {
            return redirect()->intended(RouteServiceProvider::HOME);
        }

        return redirect()->intended('/catalog');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
