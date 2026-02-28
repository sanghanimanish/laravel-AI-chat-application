<?php

return [
    /*
     |--------------------------------------------------------------------------
     | Default Chatbot Provider
     |--------------------------------------------------------------------------
     |
     | Here you may specify which of the chatbot providers below you wish
     | to use as your default provider for all chat requests.
     | Supported: "openai", "gemini"
     |
     */
    'default' => env('CHATBOT_PROVIDER', 'gemini'),

    /*
     |--------------------------------------------------------------------------
     | Chatbot Providers Configuration
     |--------------------------------------------------------------------------
     |
     | Here you may configure the drivers and settings for your AI providers.
     | If you add a new provider in the future, simply add it to this array
     | and specify the 'driver' class that implements ChatbotProviderInterface.
     |
     */
    'providers' => [
        'openai' => [
            'driver' => \App\Services\Providers\OpenAIProvider::class ,
            'api_key' => env('OPENAI_API_KEY', ''),
            'model' => env('OPENAI_MODEL', 'gpt-3.5-turbo'),
        ],

        'gemini' => [
            'driver' => \App\Services\Providers\GeminiProvider::class ,
            'api_key' => env('GEMINI_API_KEY', ''),
            'model' => env('GEMINI_MODEL', 'gemini-1.5-flash'),
        ],
    ],
];