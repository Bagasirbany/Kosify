<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();

        // If specific roles are passed, e.g. 'admin:pemilik' or 'admin:admin_web'
        if (!empty($roles)) {
            if (in_array($user->role, $roles) || $user->role === 'admin') {
                return $next($request);
            }

            if (in_array('pemilik', $roles)) {
                return redirect()->route('dashboard')->with('error', 'Akses ditolak: Halaman ini khusus untuk Pemilik Kos.');
            }

            if (in_array('admin_web', $roles)) {
                return redirect()->route('dashboard')->with('error', 'Akses ditolak: Halaman ini khusus untuk Admin Web (IT).');
            }

            return redirect('/catalog')->with('error', 'Anda tidak memiliki hak akses ke halaman ini.');
        }

        // Generic admin access (any administrative role)
        if (in_array($user->role, ['admin', 'admin_web', 'pemilik', 'owner'])) {
            return $next($request);
        }

        return redirect('/catalog')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
    }
}
