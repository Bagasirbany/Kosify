<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;
use Illuminate\Session\TokenMismatchException;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        'payment/*',
        'midtrans/callback',
        'api/midtrans-callback',
        'chatbot/message',
    ];

    /**
     * Handle an incoming request and gracefully recover from expired tokens.
     */
    public function handle($request, Closure $next)
    {
        try {
            return parent::handle($request, $next);
        } catch (TokenMismatchException $e) {
            if ($request->is('login')) {
                return redirect()->route('login')->with('error', 'Sesi login telah diperbarui secara otomatis. Silakan klik Masuk ke Akun kembali.');
            }

            return redirect()->back()->withInput($request->except(['password', '_token']))->with('error', 'Sesi form Anda telah diperbarui. Silakan coba kembali.');
        }
    }
}
