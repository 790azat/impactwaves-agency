<?php

namespace App\Support;

use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

/**
 * Markdown articles stored in resources/content/{section}/{slug}.md.
 *
 * Each file starts with a front matter block of "key: value" lines between
 * two "---" lines. List values (keywords) are comma separated.
 */
class Articles
{
    protected static ?Collection $cache = null;

    public static function all(): Collection
    {
        return static::$cache ??= collect(glob(resource_path('content/*/*.md')))
            ->map(fn (string $path) => static::parse($path))
            ->filter(fn (array $article) => isset(config('agency.sections')[$article['section']]))
            ->sortByDesc('date')
            ->values();
    }

    public static function inSection(string $section): Collection
    {
        return static::all()->where('section', $section)->values();
    }

    public static function find(string $section, string $slug): ?array
    {
        return static::all()->first(fn ($a) => $a['section'] === $section && $a['slug'] === $slug);
    }

    public static function latest(int $count = 3): Collection
    {
        return static::all()->take($count);
    }

    protected static function parse(string $path): array
    {
        $raw = file_get_contents($path);
        $meta = [];

        if (preg_match('/\A---\R(.*?)\R---\R(.*)\z/s', $raw, $m)) {
            foreach (preg_split('/\R/', $m[1]) as $line) {
                if (str_contains($line, ':')) {
                    [$key, $value] = array_map('trim', explode(':', $line, 2));
                    $meta[$key] = trim($value, '"\'');
                }
            }
            $raw = $m[2];
        }

        $html = Str::markdown($raw, ['html_input' => 'allow', 'allow_unsafe_links' => false]);

        // Give h2 headings ids so the table of contents can link to them.
        $toc = [];
        $html = preg_replace_callback('/<h2>(.*?)<\/h2>/s', function ($h) use (&$toc) {
            $text = strip_tags($h[1]);
            $id = Str::slug($text);
            $toc[] = ['id' => $id, 'text' => $text];

            return '<h2 id="'.$id.'">'.$h[1].'</h2>';
        }, $html);

        $words = str_word_count(strip_tags($html));

        return [
            'section' => basename(dirname($path)),
            'slug' => basename($path, '.md'),
            'title' => $meta['title'] ?? Str::headline(basename($path, '.md')),
            'description' => $meta['description'] ?? '',
            'keywords' => array_values(array_filter(array_map('trim', explode(',', $meta['keywords'] ?? '')))),
            'date' => Carbon::parse($meta['date'] ?? filemtime($path)),
            'updated' => isset($meta['updated']) ? Carbon::parse($meta['updated']) : null,
            'author' => $meta['author'] ?? 'Impact Waves Team',
            'tag' => $meta['tag'] ?? null,
            'html' => $html,
            'toc' => $toc,
            'minutes' => max(1, (int) ceil($words / 220)),
        ];
    }
}
