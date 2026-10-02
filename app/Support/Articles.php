<?php

namespace App\Support;

use App\Models\Article;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

/**
 * Articles come from two places:
 *
 * - Markdown files in resources/content/{section}/{slug}.md. Each file starts
 *   with a front matter block of "key: value" lines between two "---" lines.
 *   List values (keywords) are comma separated.
 * - The articles table, edited in the admin panel. A row with the same section
 *   and slug overrides the file; an unpublished row hides it.
 */
class Articles
{
    protected static ?Collection $cache = null;

    public static function all(): Collection
    {
        return static::$cache ??= static::merged()
            ->filter(fn (array $article) => $article['published'])
            ->values();
    }

    /**
     * Every article including unpublished ones, for the admin panel.
     */
    public static function merged(): Collection
    {
        $articles = static::fromFiles()->keyBy(fn ($a) => $a['section'].'/'.$a['slug']);

        foreach (static::fromDatabase() as $article) {
            $key = $article['section'].'/'.$article['slug'];
            $article['overrides_file'] = $articles->has($key) && $articles[$key]['source'] === 'file';
            // Covers live in the Markdown front matter; an edited copy keeps the file's cover.
            $article['cover'] ??= $articles[$key]['cover'] ?? null;
            $articles[$key] = $article;
        }

        return $articles
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

    public static function file(string $section, string $slug): ?array
    {
        $path = resource_path("content/$section/$slug.md");

        return is_file($path) ? static::parse($path) : null;
    }

    public static function flush(): void
    {
        static::$cache = null;
    }

    protected static function fromFiles(): Collection
    {
        return collect(glob(resource_path('content/*/*.md')))->map(fn (string $path) => static::parse($path));
    }

    protected static function fromDatabase(): Collection
    {
        if (config('database.default') === 'sqlite' && config('database.connections.sqlite.database') === ':memory:') {
            return collect();
        }

        try {
            return Article::all()->map(fn (Article $row) => static::build(
                $row->section,
                $row->slug,
                [
                    'title' => $row->title,
                    'description' => $row->description,
                    'keywords' => $row->keywords,
                    'tag' => $row->tag,
                    'author' => $row->author,
                    'date' => $row->published_on->toDateString(),
                    'updated' => $row->updated_at?->isAfter($row->published_on->copy()->endOfDay()) ? $row->updated_at->toDateString() : null,
                ],
                $row->body,
            ) + ['source' => 'database', 'id' => $row->id, 'published' => $row->published]);
        } catch (\Throwable $e) {
            Log::warning('Articles table unavailable, using Markdown files only', ['error' => $e->getMessage()]);

            return collect();
        }
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

        $meta['date'] ??= date('Y-m-d', filemtime($path));

        return static::build(basename(dirname($path)), basename($path, '.md'), $meta, $raw)
            + ['source' => 'file', 'published' => true];
    }

    protected static function build(string $section, string $slug, array $meta, string $markdown): array
    {
        $html = Str::markdown($markdown, ['html_input' => 'allow', 'allow_unsafe_links' => false]);

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
            'section' => $section,
            'slug' => $slug,
            'title' => ($meta['title'] ?? null) ?: Str::headline($slug),
            'description' => $meta['description'] ?? '',
            'keywords' => array_values(array_filter(array_map('trim', explode(',', $meta['keywords'] ?? '')))),
            'date' => Carbon::parse($meta['date']),
            'updated' => ! empty($meta['updated']) ? Carbon::parse($meta['updated']) : null,
            'author' => ($meta['author'] ?? null) ?: 'Impact Waves Team',
            'tag' => ($meta['tag'] ?? null) ?: null,
            'cover' => ($meta['cover'] ?? null) ?: null,
            'markdown' => $markdown,
            'html' => $html,
            'toc' => $toc,
            'minutes' => max(1, (int) ceil($words / 220)),
        ];
    }
}
