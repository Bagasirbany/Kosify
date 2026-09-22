<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'admin' => \App\Http\Middleware\IsAdmin::class,
        ]);
        $middleware->web(append: [
            \App\Http\Middleware\SetLocale::class,
        ]);
        $middleware->validateCsrfTokens(except: [
            'payment/*',
            'midtrans/callback',
            'api/midtrans-callback',
            'chatbot/message',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (\Symfony\Component\HttpKernel\Exception\HttpException $e, $request) {
            if ($e->getStatusCode() === 419) {
                if ($request->is('login') || $request->routeIs('login')) {
                    return redirect()->route('login')->with('error', 'Sesi login telah diperbarui secara otomatis. Silakan masukkan password dan klik Masuk kembali.');
                }

                return redirect()->back()->withInput($request->except(['password', '_token']))->with('error', 'Sesi formulir telah diperbarui. Silakan coba kembali.');
            }
        });
    })->create();
