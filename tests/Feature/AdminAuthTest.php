<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AdminAuthTest extends TestCase
{
    public function test_admin_can_authenticate_with_credentials()
    {
        $attempt = Auth::attempt([
            'email' => 'bagasirbany@gmail.com',
            'password' => 'bagas123',
        ]);

        $this->assertTrue($attempt, 'Admin credentials failed to authenticate');
    }

    public function test_auth_failed_message_is_translated_in_indonesian()
    {
        app()->setLocale('id');
        $this->assertEquals('Email atau kata sandi yang Anda masukkan salah.', trans('auth.failed'));
    }
}
