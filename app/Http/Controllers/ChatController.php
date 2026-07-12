<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ChatMessage;
use App\Services\GeminiService;

class ChatController extends Controller
{
    protected GeminiService $gemini;

    public function __construct(GeminiService $gemini)
    {
        $this->gemini = $gemini;
    }

    // View chatbot screen
    public function index()
    {
        $messages = ChatMessage::where('user_id', auth()->id())->oldest()->get();
        return view('ai.chat', compact('messages'));
    }

    // Send a message
    public function store(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        $userMessage = ChatMessage::create([
            'user_id' => auth()->id(),
            'message' => $request->message,
            'is_bot' => false,
        ]);

        // Get recent history for context
        $history = ChatMessage::where('user_id', auth()->id())
            ->where('id', '<', $userMessage->id)
            ->latest()
            ->take(10)
            ->get()
            ->reverse()
            ->map(function ($msg) {
                return [
                    'message' => $msg->message,
                    'is_bot' => (bool)$msg->is_bot
                ];
            })
            ->toArray();

        $botReplyText = $this->gemini->getChatResponse($history, $request->message);

        ChatMessage::create([
            'user_id' => auth()->id(),
            'message' => $botReplyText,
            'is_bot' => true,
        ]);

        return back();
    }
}
