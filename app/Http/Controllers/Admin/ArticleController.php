<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Support\Articles;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ArticleController extends Controller
{
    public function index(Request $request): View
    {
        $section = $request->query('section');

        return view('admin.articles.index', [
            'section' => $section,
            'articles' => Articles::merged()
                ->when(isset(config('agency.sections')[$section]), fn ($c) => $c->where('section', $section))
                ->values(),
        ]);
    }

    public function create(Request $request): View
    {
        return view('admin.articles.form', [
            'article' => [
                'section' => $request->query('section', array_key_first(config('agency.sections'))),
                'slug' => '', 'title' => '', 'description' => '', 'keywords' => [], 'tag' => '',
                'author' => '', 'markdown' => '', 'published' => true, 'date' => now(),
            ],
            'editing' => false,
        ]);
    }

    public function edit(string $section, string $slug): View
    {
        $article = Articles::merged()->first(fn ($a) => $a['section'] === $section && $a['slug'] === $slug);
        abort_unless($article, 404);

        return view('admin.articles.form', ['article' => $article, 'editing' => true]);
    }

    public function store(Request $request): RedirectResponse
    {
        $request->merge(['slug' => Str::slug($request->input('slug') ?: $request->input('title'))]);
        $data = $this->validated($request);

        if (Article::where('section', $data['section'])->where('slug', $data['slug'])->exists()
            || Articles::file($data['section'], $data['slug'])) {
            return back()->withInput()->withErrors(['slug' => 'An article with this URL already exists in this section.']);
        }

        Article::create($data);

        return redirect()->route('admin.articles.index')->with('status', 'Article created.');
    }

    /**
     * Saving a Markdown-file article stores an override in the database;
     * the file in the repository stays untouched.
     */
    public function update(Request $request, string $section, string $slug): RedirectResponse
    {
        $request->merge(['section' => $section, 'slug' => $slug]);
        $data = $this->validated($request);

        Article::updateOrCreate(['section' => $section, 'slug' => $slug], $data);

        return redirect()->route('admin.articles.edit', [$section, $slug])->with('status', 'Article saved.');
    }

    /**
     * Database articles are deleted. A file article cannot be deleted from
     * here, so it is unpublished instead; "Restore" removes the override.
     */
    public function destroy(string $section, string $slug): RedirectResponse
    {
        $row = Article::where('section', $section)->where('slug', $slug)->first();
        $file = Articles::file($section, $slug);

        if ($row && $file) {
            $row->delete();

            return back()->with('status', 'Override removed: the original version from the site files is live again.');
        }

        $row?->delete();

        return redirect()->route('admin.articles.index')->with('status', 'Article deleted.');
    }

    protected function validated(Request $request): array
    {
        $data = $request->validate([
            'section' => ['required', Rule::in(array_keys(config('agency.sections')))],
            'slug' => ['required', 'string', 'max:120', 'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/'],
            'title' => ['required', 'string', 'max:200'],
            'description' => ['nullable', 'string', 'max:500'],
            'keywords' => ['nullable', 'string', 'max:500'],
            'tag' => ['nullable', 'string', 'max:60'],
            'author' => ['nullable', 'string', 'max:120'],
            'published_on' => ['required', 'date'],
            'body' => ['required', 'string'],
        ]);

        return $data + ['published' => $request->boolean('published')];
    }
}
