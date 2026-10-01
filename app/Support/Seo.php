<?php

namespace App\Support;

/**
 * Canonical addresses point at the public domain (config agency.site_url),
 * whatever host served the request, so vercel.app copies never compete with it.
 */
class Seo
{
    public static function url(string $absolute): string
    {
        $path = parse_url($absolute, PHP_URL_PATH) ?: '/';
        $query = parse_url($absolute, PHP_URL_QUERY);

        return config('agency.site_url').($path === '/' ? '/' : rtrim($path, '/')).($query ? '?'.$query : '');
    }

    public static function canonical(): string
    {
        return static::url(request()->url());
    }

    /**
     * True when the request came in on the public domain.
     */
    public static function onPublicHost(): bool
    {
        return request()->getHost() === parse_url(config('agency.site_url'), PHP_URL_HOST);
    }

    public static function breadcrumbs(array $items): array
    {
        return [
            "\x40type" => 'BreadcrumbList',
            'itemListElement' => collect([['Home', route('home')], ...$items])->values()->map(fn ($item, $i) => [
                "\x40type" => 'ListItem', 'position' => $i + 1, 'name' => $item[0], 'item' => static::url($item[1]),
            ])->all(),
        ];
    }

    public static function jsonLd(array $data): string
    {
        return '<script type="application/ld+json">'.json_encode(["\x40context" => 'https://schema.org'] + $data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG).'</script>';
    }
}
