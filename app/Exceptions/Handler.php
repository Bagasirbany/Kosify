<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * Render an exception into an HTTP response.
     */
    public function render($request, Throwable $e)
    {
        if ($e instanceof \Illuminate\Session\TokenMismatchException) {
            if ($request->is('login') || $request->routeIs('login')) {
                return redirect()->route('login')->with('error', 'Sesi login Anda telah diperbarui secara otomatis. Silakan klik Masuk ke Akun kembali.');
            }

            return redirect()->back()->withInput($request->except(['password', '_token']))->with('error', 'Sesi formulir telah diperbarui. Silakan coba kembali.');
        }

        return parent::render($request, $e);
    }
}
