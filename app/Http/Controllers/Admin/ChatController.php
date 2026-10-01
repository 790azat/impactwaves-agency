<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ChatConversation;
use App\Support\Settings;
use App\Support\Telegram;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class ChatController extends Controller
{
    public function index(): View
    {
        return view('admin.chats.index', [
            'conversations' => ChatConversation::with('latestMessage')->withCount('messages')
                ->orderByDesc('last_message_at')->paginate(30),
            'telegram' => [
                'token' => (bool) Telegram::token(),
                'chat' => (bool) Telegram::chatId(),
                'bot' => Settings::get('telegram_bot_username'),
                'link' => ($bot = Settings::get('telegram_bot_username')) ? "https://t.me/$bot?start=".Telegram::bindCode() : null,
            ],
        ]);
    }

    public function show(ChatConversation $conversation): View
    {
        $conversation->update(['admin_read_at' => now()]);

        return view('admin.chats.show', ['conversation' => $conversation->load('messages', 'user')]);
    }

    /**
     * Answer from the admin panel; the reply is mirrored to Telegram so the
     * chat history there stays complete.
     */
    public function reply(Request $request, ChatConversation $conversation): RedirectResponse
    {
        $data = $request->validate(['body' => ['required', 'string', 'max:4000']]);

        $message = $conversation->messages()->create(['sender' => 'agent', 'body' => $data['body']]);
        $conversation->update(['last_message_at' => now(), 'admin_read_at' => now()]);

        try {
            $message->update(['telegram_message_id' => Telegram::notify("↩ Answered {$conversation->name} from the admin panel:\n\n{$data['body']}")]);
        } catch (\Throwable $e) {
            Log::warning('Could not mirror admin reply to Telegram', ['error' => $e->getMessage()]);
        }

        return back();
    }

    public function destroy(ChatConversation $conversation): RedirectResponse
    {
        $conversation->delete();

        return redirect()->route('admin.chats.index')->with('status', 'Conversation deleted.');
    }

    /**
     * Registers the webhook and remembers the bot's username for the bind link.
     */
    public function connect(): RedirectResponse
    {
        if (! Telegram::token()) {
            return back()->with('error', 'TELEGRAM_BOT_TOKEN is not set in Vercel yet.');
        }

        try {
            $bot = Telegram::call('getMe');
            Telegram::call('setWebhook', [
                'url' => route('telegram.webhook'),
                'secret_token' => Telegram::webhookSecret(),
                'allowed_updates' => ['message'],
                'drop_pending_updates' => true,
            ]);
            Settings::set('telegram_bot_username', $bot['username'] ?? null);
        } catch (\Throwable $e) {
            return back()->with('error', 'Telegram rejected the request: '.$e->getMessage());
        }

        return back()->with('status', 'Bot @'.($bot['username'] ?? '').' is connected. Now open the link below and press Start.');
    }
}
