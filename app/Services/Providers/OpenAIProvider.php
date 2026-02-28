<?php

namespace App\Services\Providers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class OpenAIProvider implements ChatbotProviderInterface
{
    protected string $apiKey;
    protected string $model;

    public function __construct(array $config)
    {
        $this->apiKey = $config['api_key'] ?? '';
        $this->model = $config['model'] ?? 'gpt-3.5-turbo';
    }

    public function sendMessage(string $message): string
    {
        if (empty($this->apiKey)) {
            return "Error: OpenAI API key is not set in your config/.env.";
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
            ])->post('https://api.openai.com/v1/chat/completions', [
                'model' => $this->model,
                'messages' => [
                    ['role' => 'system', 'content' => 'You are a helpful assistant.'],
                    ['role' => 'user', 'content' => $message],
                ],
                'temperature' => 0.7,
                'max_tokens' => 1000,
            ]);

            if ($response->successful()) {
                return $response->json('choices.0.message.content') ?? 'No response content.';
            }

            Log::error('OpenAI API Error: ' . $response->body());
            return "Sorry, I couldn't process your request with OpenAI at the moment.";
        }
        catch (\Exception $e) {
            Log::error('OpenAI Service Exception: ' . $e->getMessage());
            return "An unexpected error occurred while contacting OpenAI.";
        }
    }
}