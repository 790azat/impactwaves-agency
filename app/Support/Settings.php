<?php

namespace App\Support;

use Illuminate\Support\Facades\DB;

/**
 * Small key/value store for values set at runtime (for example the Telegram
 * chat that receives notifications), since Vercel env vars need a redeploy.
 */
class Settings
{
    protected static array $loaded = [];

    public static function get(string $key, mixed $default = null): mixed
    {
        if (! array_key_exists($key, static::$loaded)) {
            try {
                static::$loaded[$key] = DB::table('settings')->where('key', $key)->value('value');
            } catch (\Throwable) {
                return $default;
            }
        }

        return static::$loaded[$key] ?? $default;
    }

    public static function set(string $key, ?string $value): void
    {
        DB::table('settings')->updateOrInsert(['key' => $key], ['value' => $value, 'updated_at' => now(), 'created_at' => now()]);
        static::$loaded[$key] = $value;
    }
}
