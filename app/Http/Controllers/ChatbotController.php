<?php

namespace App\Http\Controllers;

use App\Models\ChatMessage;
use App\Services\AIChatService;
use Illuminate\Http\Request;

class ChatbotController extends Controller
{
    protected $aiChatService;

    public function __construct(AIChatService $aiChatService)
    {
        $this->aiChatService = $aiChatService;
    }

    public function index()
    {
        $messages = ChatMessage::orderBy('created_at', 'asc')->get();
        return view('chatbot', compact('messages'));
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
        ]);

        $userMessage = $request->input('message');

        // Get bot response via AIChatService
        $botResponse = $this->aiChatService->getResponse($userMessage);

        // Save to database
        $chatMessage = ChatMessage::create([
            'user_message' => $userMessage,
            'bot_response' => $botResponse,
        ]);

        return response()->json([
            'status' => 'success',
            'chat_message' => $chatMessage
        ]);
    }
}