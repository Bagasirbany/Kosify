<?php

namespace Tests\Feature;

use Tests\TestCase;

class ChatbotBilingualTest extends TestCase
{
    public function test_chatbot_responds_in_english_for_facilities_when_english_locale(): void
    {
        $response = $this->postJson('/chatbot/message', [
            'message' => 'What are the room facilities, WiFi, and shared kitchen like?',
            'locale' => 'en'
        ]);

        $response->assertStatus(200);
        $reply = $response->json('reply');
        $this->assertStringContainsString('Complete Facilities at Kosify', $reply);
        $this->assertStringContainsString('Plush springbed', $reply);
    }

    public function test_chatbot_responds_in_indonesian_for_facilities_when_indonesian_locale(): void
    {
        $response = $this->postJson('/chatbot/message', [
            'message' => 'Fasilitas kamar, WiFi, dan dapur bersama seperti apa?',
            'locale' => 'id'
        ]);

        $response->assertStatus(200);
        $reply = $response->json('reply');
        $this->assertStringContainsString('Fasilitas Lengkap di Kosify', $reply);
        $this->assertStringContainsString('Kasur springbed empuk', $reply);
    }

    public function test_chatbot_responds_in_english_for_prices_when_english_locale(): void
    {
        $response = $this->postJson('/chatbot/message', [
            'message' => 'What are the room rental rates?',
            'locale' => 'en'
        ]);

        $response->assertStatus(200);
        $reply = $response->json('reply');
        $this->assertStringContainsString('Rental Rates Breakdown', $reply);
    }
}
