<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\WhatsAppGatewayService;
use App\Models\User;
use App\Models\Room;
use App\Models\Reservation;
use App\Models\Complaint;
use Illuminate\Support\Str;

class WhatsAppGatewayServiceTest extends TestCase
{
    public function test_phone_number_formatting(): void
    {
        $service = new WhatsAppGatewayService();

        $this->assertEquals('628123456789', $service->formatPhoneNumber('08123456789'));
        $this->assertEquals('628123456789', $service->formatPhoneNumber('8123456789'));
        $this->assertEquals('6285815721534', $service->formatPhoneNumber('+62 858-1572-1534'));
    }

    public function test_send_simulated_dispatch(): void
    {
        $service = new WhatsAppGatewayService();
        $result = $service->send('08123456789', 'Halo uji coba notifikasi gateway Kosify');

        $this->assertTrue($result['success']);
        $this->assertArrayHasKey('direct_url', $result);
        $this->assertStringContainsString('628123456789', $result['direct_url']);
    }

    public function test_send_booking_and_payment_notifications(): void
    {
        $service = new WhatsAppGatewayService();

        $user = User::first() ?? User::factory()->create(['phone' => '081234567890']);
        $room = Room::first() ?? Room::factory()->create(['room_number' => '101']);

        $reservation = Reservation::create([
            'id' => (string) Str::uuid(),
            'user_id' => $user->id,
            'room_id' => $room->id,
            'start_date' => now()->toDateString(),
            'end_date' => now()->addMonth()->toDateString(),
            'duration_months' => 1,
            'status' => 'pending',
            'total_price' => 1500000,
        ]);

        $bookingResult = $service->sendBookingCreatedNotification($reservation);
        $this->assertTrue($bookingResult['success']);

        $paymentResult = $service->sendPaymentVerifiedNotification($reservation);
        $this->assertTrue($paymentResult['success']);
    }
}
