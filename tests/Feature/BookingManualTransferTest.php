<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Room;
use App\Models\Reservation;
use Tests\TestCase;

class BookingManualTransferTest extends TestCase
{
    public function test_booking_create_page_shows_manual_transfer_only(): void
    {
        $user = User::first() ?? User::factory()->create();
        $room = Room::first() ?? Room::factory()->create([
            'room_number' => '999',
            'status' => 'available',
            'price_per_month' => 1500000,
        ]);

        $response = $this->actingAs($user)->get(route('bookings.checkout', $room->id));

        $response->assertStatus(200);
        $response->assertSee('Transfer Bank Resmi (BCA / Mandiri / BRI)', false);
        $response->assertSee('KONFIRMASI RESERVASI', false);
        $response->assertDontSee('Payment Gateway (QRIS &amp; Virtual Account Otomatis)', false);
        $response->assertDontSee('BAYAR VIA PAYMENT GATEWAY', false);
    }

    public function test_my_bookings_page_shows_transfer_button_instead_of_gateway(): void
    {
        $user = User::first() ?? User::factory()->create();

        $response = $this->actingAs($user)->get(route('bookings.my'));

        $response->assertStatus(200);
        $response->assertDontSee('BAYAR VIA PAYMENT GATEWAY', false);
        $response->assertDontSee('openGatewayModal', false);
    }
}
