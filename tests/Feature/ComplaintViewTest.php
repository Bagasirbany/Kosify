<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class ComplaintViewTest extends TestCase
{
    public function test_complaints_index_page_can_be_rendered(): void
    {
        $user = User::first() ?? User::factory()->create();

        $response = $this->actingAs($user)->get(route('complaints.index'));

        $response->assertStatus(200);
        $response->assertSee('Lapor Kendala & Fasilitas', false);
        $response->assertSee('Semua Fasilitas Berfungsi Normal', false);
        $response->assertSee('Ketentuan & Waktu Penanganan', false);
        $response->assertSee('Waktu Penanganan:', false);
    }
}
