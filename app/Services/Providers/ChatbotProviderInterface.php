<?php

namespace App\Services\Providers;

interface ChatbotProviderInterface
{
    /**
     * Send a message to the AI provider and return the response.
     *
     * @param string $message
     * @return string
     */
    public function sendMessage(string $message): string;
}