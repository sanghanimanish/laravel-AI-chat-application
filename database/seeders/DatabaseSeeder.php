<?php

namespace Database\Seeders;

use App\Models\ChatMessage;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        ChatMessage::create([
            'user_message' => 'Hello',
            'bot_response' => 'Hi there! How can I help you today?',
        ]);

        ChatMessage::create([
            'user_message' => 'What can you do?',
            'bot_response' => 'I am an AI assistant here to help you with your queries.',
        ]);
    }
}