<?php

namespace App\Livewire;

use App\Models\ChatConversation;
use App\Support\Telegram;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Attributes\Locked;
use Livewire\Component;

/**
 * Floating site chat. Visitor messages are forwarded to the team's Telegram
 * chat; replies there come back through the webhook and show up on the next poll.
 */
class ChatWidget extends Component
{
    public bool $open = false;

    public string $name = '';

    public string $email = '';

    public string $body = '';

    #[Locked]
    public ?int $conversationId = null;

    public int $seen = 0;

    public function mount(): void
    {
        $this->conversationId = session('chat_conversation_id');
        $this->seen = (int) session('chat_seen', 0);

        if ($user = Auth::user()) {
            $this->name = $user->name;
            $this->email = $user->email;
        }
    }

    public function toggle(): void
    {
        $this->open = ! $this->open;
    }

    public function send(): void
    {
        $conversation = $this->conversation();

        $this->validate([
            'body' => ['required', 'string', 'max:2000'],
            'name' => [$conversation ? 'nullable' : 'required', 'string', 'min:2', 'max:80'],
            'email' => ['nullable', 'email', 'max:120'],
        ], [], ['body' => 'message']);

        $key = 'chat:'.request()->ip();
        if (RateLimiter::tooManyAttempts($key, 20)) {
            $this->addError('body', 'You are sending messages too fast. Please wait a minute.');

            return;
        }
        RateLimiter::hit($key, 600);

        if (! $conversation) {
            $conversation = ChatConversation::create([
                'user_id' => Auth::id(),
                'name' => $this->name,
                'email' => $this->email ?: null,
                'page_url' => mb_substr((string) request()->header('Referer'), 0, 500) ?: null,
                'ip_address' => request()->ip(),
            ]);
            $this->conversationId = $conversation->id;
            session(['chat_conversation_id' => $conversation->id]);
            $first = true;
        }

        $message = $conversation->messages()->create(['sender' => 'visitor', 'body' => $this->body]);
        $conversation->update(['last_message_at' => now()]);

        try {
            $text = isset($first)
                ? "💬 New chat #{$conversation->id}: {$conversation->name}".($conversation->email ? " · {$conversation->email}" : '')
                    .($conversation->page_url ? "\nPage: {$conversation->page_url}" : '')."\n\n{$this->body}\n\n(Reply to this message to answer.)"
                : "💬 #{$conversation->id} {$conversation->name}:\n\n{$this->body}";
            $message->update(['telegram_message_id' => Telegram::notify($text)]);
        } catch (\Throwable $e) {
            Log::error('Chat message was not forwarded to Telegram', ['error' => $e->getMessage()]);
        }

        $this->reset('body');
    }

    protected function conversation(): ?ChatConversation
    {
        return $this->conversationId ? ChatConversation::find($this->conversationId) : null;
    }

    public function render()
    {
        $messages = collect();

        // Shown once the bot is connected, so every message reaches the team.
        $available = Telegram::ready();

        if ($available) {
            try {
                $messages = $this->conversation()?->messages()->get() ?? collect();
            } catch (\Throwable) {
                $available = false;
            }
        }

        $agentCount = $messages->where('sender', 'agent')->count();
        if ($this->open && $this->seen !== $agentCount) {
            $this->seen = $agentCount;
            session(['chat_seen' => $agentCount]);
        }

        return view('livewire.chat-widget', [
            'available' => $available,
            'messages' => $messages,
            'unread' => max(0, $agentCount - $this->seen),
        ]);
    }

    public function placeholder(): string
    {
        return '<div></div>';
    }
}
