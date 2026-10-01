@php
    $fromFile = $editing && $article['source'] === 'file';
    $overridesFile = $editing && ($article['overrides_file'] ?? false);
    $dbOnly = $editing && $article['source'] === 'database' && ! $overridesFile;
@endphp
<x-layouts.admin :title="$editing ? $article['title'] : 'New article'">
    <x-slot:header>
        <div>
            <a href="{{ route('admin.articles.index') }}" class="inline-flex items-center gap-1.5 text-sm text-slate-500 hover:text-ocean-950"><x-icon name="arrow-left" class="size-4" /> Articles</a>
            <h1 class="mt-2 font-display text-3xl font-semibold tracking-tight text-ocean-950">{{ $editing ? 'Edit article' : 'New article' }}</h1>
        </div>
        @if ($editing && $article['published'])
            <a href="{{ route('article', [$article['section'], $article['slug']]) }}" target="_blank" class="btn btn-ghost"><x-icon name="eye" class="size-4" /> View on site</a>
        @endif
    </x-slot:header>

    @if ($fromFile)
        <p class="mb-6 rounded-lg border border-ocean-200 bg-ocean-50 px-4 py-3 text-sm text-ocean-900">This article comes from the site files. When you save, your version replaces it on the site; you can always go back to the original.</p>
    @endif

    <form method="POST" action="{{ $editing ? route('admin.articles.update', [$article['section'], $article['slug']]) : route('admin.articles.store') }}" class="grid gap-6 lg:grid-cols-3">
        @csrf
        @if ($editing) @method('PUT') @endif

        <div class="grid content-start gap-5 rounded-xl border border-ocean-100 bg-white p-6 lg:col-span-2">
            <x-auth.input name="title" label="Title" :value="$article['title']" required />
            <label class="grid gap-2">
                <span class="text-sm font-medium text-slate-700">Description <span class="font-normal text-slate-500">(search snippet and card text)</span></span>
                <textarea name="description" rows="2" maxlength="500" class="field resize-y">{{ old('description', $article['description']) }}</textarea>
                @error('description') <span class="text-sm text-rose-600">{{ $message }}</span> @enderror
            </label>
            <label class="grid gap-2">
                <span class="flex justify-between text-sm font-medium text-slate-700">Text <span class="font-normal text-slate-500">Markdown: ## Heading, **bold**, [link](https://…), - list</span></span>
                <textarea name="body" rows="24" required class="field resize-y font-mono text-sm leading-relaxed">{{ old('body', $article['markdown']) }}</textarea>
                @error('body') <span class="text-sm text-rose-600">{{ $message }}</span> @enderror
            </label>
        </div>

        <aside class="grid content-start gap-5">
            <div class="grid gap-5 rounded-xl border border-ocean-100 bg-white p-6">
                <label class="grid gap-2">
                    <span class="text-sm font-medium text-slate-700">Section</span>
                    <select name="section" class="field" @disabled($editing)>
                        @foreach (config('agency.sections') as $key => $s)
                            <option value="{{ $key }}" @selected(old('section', $article['section']) === $key)>{{ $s['title'] }}</option>
                        @endforeach
                    </select>
                    @error('section') <span class="text-sm text-rose-600">{{ $message }}</span> @enderror
                </label>
                @if ($editing)
                    <div class="grid gap-2"><span class="text-sm font-medium text-slate-700">URL</span><span class="text-sm break-all text-slate-600">/{{ $article['section'] }}/{{ $article['slug'] }}</span></div>
                @else
                    <x-auth.input name="slug" label="URL slug" :value="$article['slug']" placeholder="Generated from the title" hint="Lowercase words separated by dashes." />
                @endif
                <x-auth.input name="published_on" type="date" label="Publication date" :value="$article['date']->toDateString()" required />
                <x-auth.input name="tag" label="Tag" :value="$article['tag']" placeholder="e.g. Search feeds" />
                <x-auth.input name="keywords" label="SEO keywords" :value="implode(', ', $article['keywords'])" placeholder="comma, separated" />
                <x-auth.input name="author" label="Author" :value="$article['author'] === 'Impact Waves Team' && ! $editing ? '' : $article['author']" placeholder="Impact Waves Team" />
                <label class="flex items-center gap-2.5 text-sm font-medium text-slate-700">
                    <input type="hidden" name="published" value="0">
                    <input type="checkbox" name="published" value="1" class="size-4 accent-ocean-600" @checked(old('published', $article['published']))> Published on the site
                </label>
                <button type="submit" class="btn btn-primary">{{ $editing ? 'Save changes' : 'Create article' }}</button>
            </div>
        </aside>
    </form>

    @if ($overridesFile || $dbOnly)
        <form method="POST" action="{{ route('admin.articles.destroy', [$article['section'], $article['slug']]) }}" class="mt-6"
              onsubmit="return confirm({{ \Illuminate\Support\Js::from($overridesFile ? 'Discard your edits and restore the original version?' : 'Delete this article permanently?') }})">
            @csrf @method('DELETE')
            <button type="submit" class="inline-flex items-center gap-2 text-sm font-medium text-rose-600 hover:text-rose-800">
                <x-icon :name="$overridesFile ? 'refresh' : 'trash'" class="size-4" /> {{ $overridesFile ? 'Restore original version' : 'Delete article' }}
            </button>
        </form>
    @endif
</x-layouts.admin>
