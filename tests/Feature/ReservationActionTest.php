<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Room;
use App\Models\Reservation;
use Illuminate\Support\Str;

class ReservationActionTest extends TestCase
{
    public function test_user_can_terminate_contract_without_error()
    {
        $user = User::where('email', 'bagasirbany@gmail.com')->first();
        if (!$user) {
            $user = User::factory()->create(['role' => 'admin']);
        }

        $room = Room::first();
        $reservation = Reservation::create([
            'id' => Str::uuid()->toString(),
            'user_id' => $user->id,
            'room_id' => $room->id,
            'start_date' => now()->toDateString(),
            'end_date' => now()->addMonth()->toDateString(),
            'duration_months' => 1,
            'status' => 'confirmed',
            'total_price' => 1550000,
        ]);

        $response = $this->actingAs($user)->post(route('bookings.terminate', $reservation->id));

        $response->assertStatus(302);
        $this->assertDatabaseHas('reservations', [
            'id' => $reservation->id,
            'extension_decision' => 'will_checkout',
        ]);
    }

    public function test_user_can_cancel_pending_reservation()
    {
        $user = User::where('email', 'bagasirbany@gmail.com')->first();
        if (!$user) {
            $user = User::factory()->create(['role' => 'admin']);
        }

        $room = Room::first();
        $reservation = Reservation::create([
            'id' => Str::uuid()->toString(),
            'user_id' => $user->id,
            'room_id' => $room->id,
            'start_date' => now()->toDateString(),
            'end_date' => now()->addMonth()->toDateString(),
            'duration_months' => 1,
            'status' => 'pending',
            'total_price' => 1550000,
        ]);

        $response = $this->actingAs($user)->post(route('bookings.cancel', $reservation->id));

        $response->assertRedirect(route('bookings.my'));
        $this->assertDatabaseHas('reservations', [
            'id' => $reservation->id,
            'status' => 'cancelled',
        ]);
    }

    public function test_user_cannot_cancel_confirmed_reservation()
    {
        $user = User::where('email', 'bagasirbany@gmail.com')->first();
        if (!$user) {
            $user = User::factory()->create(['role' => 'admin']);
        }

        $room = Room::first();
        $reservation = Reservation::create([
            'id' => Str::uuid()->toString(),
            'user_id' => $user->id,
            'room_id' => $room->id,
            'start_date' => now()->toDateString(),
            'end_date' => now()->addMonth()->toDateString(),
            'duration_months' => 1,
            'status' => 'confirmed',
            'total_price' => 1550000,
        ]);

        $response = $this->actingAs($user)->post(route('bookings.cancel', $reservation->id));

        $response->assertStatus(302);
        $this->assertDatabaseHas('reservations', [
            'id' => $reservation->id,
            'status' => 'confirmed',
        ]);
    }
}
