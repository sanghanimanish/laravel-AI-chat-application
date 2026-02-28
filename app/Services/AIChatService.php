<?php

namespace App\Services;

use App\Services\Providers\ChatbotProviderInterface;

class AIChatService
{
    /**
     * Retrieves a response from the default configured AI provider.
     */
    public function getResponse(string $userMessage): string
    {
        try {
            $provider = $this->resolveProvider();
            return $provider->sendMessage($userMessage);
        }
        catch (\Exception $e) {
            return "System Error: " . $e->getMessage();
        }
    }

    /**
     * Resolves the active provider class dynamically based on configuration.
     */
    protected function resolveProvider(): ChatbotProviderInterface
    {
        $default = config('chatbot.default', 'gemini');
        $config = config("chatbot.providers.{$default}");

        if (!$config) {
            throw new \Exception("Chatbot Provider configuration for '{$default}' not found.");
        }

        $driverClass = $config['driver'] ?? null;

        if (!$driverClass || !class_exists($driverClass)) {
            throw new \Exception("Driver class for provider '{$default}' is missing or invalid.");
        }

        $provider = new $driverClass($config);

        if (!$provider instanceof ChatbotProviderInterface) {
            throw new \Exception("Driver {$driverClass} must implement ChatbotProviderInterface.");
        }

        return $provider;
    }
}