<?php

namespace App\Support;

use Illuminate\Support\Facades\Http;

/**
 * The Impact Waves bot: forwards site chat and leads to the team's Telegram
 * chat and receives replies through a webhook.
 *
 * Set TELEGRAM_BOT_TOKEN in Vercel, then use "Connect" in the admin panel:
 * it registers the webhook and gives a link that binds the admin's chat.
 * TELEGRAM_CHAT_ID still works as a fixed chat if set.
 */
class Telegram
{
    public static function token(): ?string
    {
        return config('services.telegram.bot_token') ?: null;
    }

    public static function chatId(): ?string
    {
        return config('services.telegram.chat_id') ?: Settings::get('telegram_chat_id');
    }

    public static function ready(): bool
    {
        return static::token() && static::chatId();
    }

    /** Secret Telegram sends back in a header so the webhook can trust the update. */
    public static function webhookSecret(): string
    {
        return substr(hash_hmac('sha256', 'telegram-webhook', config('app.key')), 0, 40);
    }

    /** Code in the t.me/bot?start=... link that binds a chat to the site. */
    public static function bindCode(): string
    {
        return substr(hash_hmac('sha256', 'telegram-bind', config('app.key')), 0, 24);
    }

    public static function call(string $method, array $params = []): array
    {
        return Http::timeout(8)
            ->post('https://api.telegram.org/bot'.static::token().'/'.$method, $params)
            ->throw()
            ->json('result') ?? [];
    }

    /**
     * Send a plain text message to the team chat. Returns the Telegram message id.
     */
    public static function notify(string $text, array $extra = []): ?int
    {
        if (! static::ready()) {
            return null;
        }

        $result = static::call('sendMessage', [
            'chat_id' => static::chatId(),
            'text' => mb_substr($text, 0, 4000),
            'link_preview_options' => ['is_disabled' => true],
        ] + $extra);

        return $result['message_id'] ?? null;
    }
}
