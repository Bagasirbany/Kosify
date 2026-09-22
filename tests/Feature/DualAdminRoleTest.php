<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DualAdminRoleTest extends TestCase
{
    public function test_admin_web_can_authenticate_and_has_proper_role()
    {
        $attempt = Auth::attempt([
            'email' => 'admin@gmail.com',
            'password' => 'admin123',
        ]);

        $this->assertTrue($attempt, 'Admin Web authentication failed');
        $this->assertEquals('admin_web', Auth::user()->role);
        $this->assertTrue(Auth::user()->isAdminWeb());
    }

    public function test_pemilik_can_authenticate_and_has_proper_role()
    {
        $attempt = Auth::attempt([
            'email' => 'bagasirbany@gmail.com',
            'password' => 'bagas123',
        ]);

        $this->assertTrue($attempt, 'Pemilik authentication failed');
        $this->assertEquals('pemilik', Auth::user()->role);
        $this->assertTrue(Auth::user()->isPemilik());
    }

    public function test_admin_web_can_access_users_management_and_settings()
    {
        $admin = User::where('email', 'admin@gmail.com')->first();

        $response = $this->actingAs($admin)->get(route('admin.users.index'));
        $response->assertStatus(200);

        $response = $this->actingAs($admin)->get(route('settings.index'));
        $response->assertStatus(200);
    }

    public function test_admin_web_is_restricted_from_finance_and_reports()
    {
        $admin = User::where('email', 'admin@gmail.com')->first();

        $response = $this->actingAs($admin)->get(route('finance.index'));
        $response->assertRedirect(route('dashboard'));
        $response->assertSessionHas('error');

        $response = $this->actingAs($admin)->get(route('reports.index'));
        $response->assertRedirect(route('dashboard'));
        $response->assertSessionHas('error');
    }

    public function test_pemilik_can_access_finance_and_reports()
    {
        $pemilik = User::where('email', 'bagasirbany@gmail.com')->first();

        $response = $this->actingAs($pemilik)->get(route('finance.index'));
        $response->assertStatus(200);

        $response = $this->actingAs($pemilik)->get(route('reports.index'));
        $response->assertStatus(200);
    }

    public function test_pemilik_is_restricted_from_web_settings_and_user_management()
    {
        $pemilik = User::where('email', 'bagasirbany@gmail.com')->first();

        $response = $this->actingAs($pemilik)->get(route('settings.index'));
        $response->assertRedirect(route('dashboard'));
        $response->assertSessionHas('error');

        $response = $this->actingAs($pemilik)->get(route('admin.users.index'));
        $response->assertRedirect(route('dashboard'));
        $response->assertSessionHas('error');
    }

    public function test_admin_web_can_update_user_role()
    {
        $admin = User::where('email', 'admin@gmail.com')->first();
        $targetUser = User::where('email', 'penyewa@kosify.com')->first();

        $response = $this->actingAs($admin)->patch(route('admin.users.updateRole', $targetUser->id), [
            'role' => 'pemilik',
        ]);

        $response->assertStatus(302);
        $this->assertDatabaseHas('users', [
            'id' => $targetUser->id,
            'role' => 'pemilik',
        ]);

        // Revert back
        $targetUser->role = 'penyewa';
        $targetUser->save();
    }
}
