<?php

namespace App\Support;

/**
 * Service page copy edited in Admin → Services. Edits are stored in the
 * settings table and merged over config('agency.services') on every request,
 * so the home page, services pages, footer and contact form all pick them up.
 */
class ServiceTexts
{
    public const FIELDS = ['title', 'eyebrow', 'short', 'headline', 'intro', 'platforms', 'features'];

    public static function apply(): void
    {
        $defaults = config('agency.services_defaults') ?? config('agency.services');
        $edits = static::edits();

        $services = [];
        foreach ($defaults as $slug => $service) {
            $services[$slug] = array_merge($service, array_intersect_key($edits[$slug] ?? [], array_flip(static::FIELDS)));
        }

        config(['agency.services_defaults' => $defaults, 'agency.services' => $services]);
    }

    public static function edits(): array
    {
        return json_decode((string) Settings::get('services'), true) ?: [];
    }

    public static function save(string $slug, ?array $fields): void
    {
        $edits = static::edits();

        if ($fields === null) {
            unset($edits[$slug]);
        } else {
            $edits[$slug] = $fields;
        }

        Settings::set('services', json_encode($edits, JSON_UNESCAPED_UNICODE));
        static::apply();
    }
}
