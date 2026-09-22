<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    public function test_profile_page_can_be_rendered(): void
    {
        $user = User::first() ?? User::factory()->create();

        $response = $this->actingAs($user)->get(route('profile.edit'));

        $response->assertStatus(200);
        $response->assertSee('Profil & Pengaturan Akun', false);
        $response->assertSee('STATUS AKUN');
        $response->assertSee('HUNIAN AKTIF');
        $response->assertSee('AKTIVITAS PENYEWA');
    }
}
