<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\ChatMessage;
use App\Services\AIChatService;
use Mockery\MockInterface;

class ChatbotTest extends TestCase
{
    use RefreshDatabase;

    public function test_chatbot_page_loads()
    {
        $response = $this->get('/chat');

        $response->assertStatus(200);
        $response->assertSee('AI Assistant');
    }

    public function test_message_can_be_sent_to_chatbot()
    {
        // Mock the AIChatService to prevent real API calls during testing
        $this->mock(AIChatService::class , function (MockInterface $mock) {
            $mock->shouldReceive('getResponse')
                ->once()
                ->with('Hello bot')
                ->andReturn('Hello mock bot response');
        });

        $response = $this->postJson('/chat/send', [
            'message' => 'Hello bot'
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'status' => 'success',
            'chat_message' => [
                'user_message' => 'Hello bot',
                'bot_response' => 'Hello mock bot response',
            ]
        ]);

        $this->assertDatabaseHas('chat_messages', [
            'user_message' => 'Hello bot',
            'bot_response' => 'Hello mock bot response',
        ]);
    }
}