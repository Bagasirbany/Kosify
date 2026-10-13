<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Room;
use App\Models\Reservation;
use Tests\TestCase;

class BookingManualTransferTest extends TestCase
{
    public function test_booking_create_page_shows_payment_options(): void
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
        $response->assertSee('Payment Gateway Otomatis (QRIS &amp; Virtual Account)', false);
        $response->assertSee('KONFIRMASI RESERVASI', false);
    }

    public function test_my_bookings_page_shows_payment_gateway_and_manual_buttons(): void
    {
        $user = User::first() ?? User::factory()->create();

        $response = $this->actingAs($user)->get(route('bookings.my'));

        $response->assertStatus(200);
        $response->assertSee('Gerbang Pembayaran Otomatis', false);
        $response->assertSee('Transfer Bank Manual', false);
    }

    public function test_payment_gateway_token_and_auto_verification(): void
    {
        $user = User::first() ?? User::factory()->create();
        $room = Room::first() ?? Room::factory()->create([
            'room_number' => '888',
            'status' => 'available',
            'price_per_month' => 1500000,
        ]);

        $reservation = Reservation::create([
            'id' => (string) \Illuminate\Support\Str::uuid(),
            'user_id' => $user->id,
            'room_id' => $room->id,
            'start_date' => now()->toDateString(),
            'end_date' => now()->addMonth()->toDateString(),
            'duration_months' => 1,
            'status' => 'pending',
            'total_price' => 1550000,
        ]);

        // Request payment gateway token
        $response = $this->actingAs($user)->postJson(route('payment.token', $reservation->id));
        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'mode' => 'gateway',
            'reservation_id' => $reservation->id,
        ]);

        // Finish instant gateway payment
        $finishResponse = $this->actingAs($user)->postJson(route('payment.finish', $reservation->id), [
            'payment_method' => 'Midtrans Payment Gateway (QRIS/VA)',
            'transaction_id' => 'PG-TEST-998811',
        ]);
        $finishResponse->assertStatus(200);
        $finishResponse->assertJson([
            'success' => true,
        ]);

        $this->assertEquals('active', $reservation->fresh()->status);
        $this->assertEquals('occupied', $room->fresh()->status);
    }
}
