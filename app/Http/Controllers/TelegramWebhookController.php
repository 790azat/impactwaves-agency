<?php

namespace App\Http\Controllers;

use App\Models\ChatMessage;
use App\Support\Settings;
use App\Support\Telegram;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class TelegramWebhookController extends Controller
{
    public function __invoke(Request $request): Response
    {
        abort_unless(hash_equals(Telegram::webhookSecret(), (string) $request->header('X-Telegram-Bot-Api-Secret-Token')), 403);

        $message = $request->input('message');
        $chatId = (string) data_get($message, 'chat.id');
        $text = trim((string) data_get($message, 'text'));

        if (! $message || $chatId === '' || $text === '') {
            return response()->noContent();
        }

        try {
            if (str_starts_with($text, '/start')) {
                $this->bind($chatId, trim(substr($text, 6)));
            } elseif ($chatId === (string) Telegram::chatId()) {
                $this->reply($message, $text);
            }
        } catch (\Throwable $e) {
            Log::error('Telegram webhook failed', ['error' => $e->getMessage()]);
        }

        // Always 200 so Telegram does not retry the same update forever.
        return response()->noContent();
    }

    /**
     * "/start <code>" from the link in the admin panel makes this chat the
     * one that receives site chats and leads.
     */
    protected function bind(string $chatId, string $code): void
    {
        if (! hash_equals(Telegram::bindCode(), $code)) {
            return;
        }

        Settings::set('telegram_chat_id', $chatId);

        Telegram::call('sendMessage', [
            'chat_id' => $chatId,
            'text' => "Connected to impactwaves.agency.\n\nNew site chats and contact form leads will arrive here. To answer a visitor, reply to their message (swipe left on it, or long press and Reply).",
        ]);
    }

    /**
     * A Telegram reply to a forwarded visitor message goes back to that chat.
     */
    protected function reply(array $message, string $text): void
    {
        $repliedTo = data_get($message, 'reply_to_message.message_id');
        $source = $repliedTo ? ChatMessage::where('telegram_message_id', $repliedTo)->latest('id')->first() : null;

        if (! $source) {
            Telegram::call('sendMessage', [
                'chat_id' => data_get($message, 'chat.id'),
                'text' => 'To answer a visitor, reply to their message (swipe left on it, or long press and Reply).',
            ]);

            return;
        }

        $conversation = $source->conversation;
        $conversation->messages()->create([
            'sender' => 'agent',
            'body' => mb_substr($text, 0, 4000),
            'telegram_message_id' => data_get($message, 'message_id'),
        ]);
        $conversation->update(['last_message_at' => now(), 'admin_read_at' => now()]);

        // A quiet confirmation that the reply reached the site.
        Telegram::call('setMessageReaction', [
            'chat_id' => data_get($message, 'chat.id'),
            'message_id' => data_get($message, 'message_id'),
            'reaction' => [['type' => 'emoji', 'emoji' => '👍']],
        ]);
    }
}
