<?php

namespace App\Support;

/**
 * Content sections that can be switched off in Admin → Articles. A switched-off
 * section disappears from the menu, footer, sitemap and feed, and its pages 404;
 * its articles stay editable in the admin panel.
 */
class Sections
{
    // Sections with a switch, and whether each is on before anyone touches it.
    public const TOGGLEABLE = ['news' => false];

    public static function enabled(string $key): bool
    {
        if (! array_key_exists($key, static::TOGGLEABLE)) {
            return true;
        }

        return (bool) Settings::get("sections.$key.enabled", static::TOGGLEABLE[$key] ? '1' : '0');
    }

    public static function visible(): array
    {
        return array_filter(config('agency.sections'), fn ($section, $key) => static::enabled($key), ARRAY_FILTER_USE_BOTH);
    }

    public static function set(string $key, bool $enabled): void
    {
        Settings::set("sections.$key.enabled", $enabled ? '1' : '0');
        Articles::flush();
    }
}
