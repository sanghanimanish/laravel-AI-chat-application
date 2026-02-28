<?php

namespace App\Services\Providers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeminiProvider implements ChatbotProviderInterface
{
    protected string $apiKey;
    protected string $model;

    public function __construct(array $config)
    {
        $this->apiKey = $config['api_key'] ?? '';
        $this->model = $config['model'] ?? 'gemini-1.5-flash';
    }

    public function sendMessage(string $message): string
    {
        if (empty($this->apiKey)) {
            return "Error: Gemini API key is not set in your config/.env.";
        }

        try {
            $url = "https://generativelanguage.googleapis.com/v1beta/models/{$this->model}:generateContent?key={$this->apiKey}";

            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post($url, [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $message]
                        ]
                    ]
                ]
            ]);

            if ($response->successful()) {
                $text = $response->json('candidates.0.content.parts.0.text');
                return $text ?? 'No response content from Gemini.';
            }

            Log::error('Gemini API Error: ' . $response->body());
            return "Sorry, I couldn't process your request with Gemini at the moment.";
        }
        catch (\Exception $e) {
            Log::error('Gemini Service Exception: ' . $e->getMessage());
            return "An unexpected error occurred while contacting Gemini.";
        }
    }
}