<x-layouts.admin title="Articles">
    <x-slot:header>
        <x-admin.heading title="Articles" lead="Guides, traffic provider articles and news shown on the site." />
        <a href="{{ route('admin.articles.create', array_filter(['section' => $section])) }}" class="btn btn-primary"><x-icon name="plus" class="size-4" /> New article</a>
    </x-slot:header>

    @foreach (\App\Support\Sections::TOGGLEABLE as $key => $default)
        @php $on = \App\Support\Sections::enabled($key); @endphp
        <form method="POST" action="{{ route('admin.sections.toggle', $key) }}" class="mb-5 flex flex-wrap items-center justify-between gap-4 rounded-xl border border-ocean-100 bg-white px-5 py-4">
            @csrf
            @method('PUT')
            <input type="hidden" name="enabled" value="{{ $on ? 0 : 1 }}">
            <div>
                <p class="font-semibold text-ocean-950">{{ config("agency.sections.$key.title") }} section</p>
                <p class="text-sm text-slate-500">{{ $on ? 'Shown on the site: menu, footer, sitemap and its pages.' : 'Hidden from the site. Articles stay here and can be edited.' }}</p>
            </div>
            <button type="submit" role="switch" aria-checked="{{ $on ? 'true' : 'false' }}" aria-label="Show {{ config("agency.sections.$key.title") }} on the site" class="flex items-center gap-3 text-sm font-medium text-slate-600">
                <span @class(['relative inline-flex h-6 w-11 shrink-0 rounded-full transition', 'bg-ocean-600' => $on, 'bg-slate-300' => ! $on])>
                    <span @class(['absolute top-0.5 size-5 rounded-full bg-white shadow transition-all', 'left-[1.375rem]' => $on, 'left-0.5' => ! $on])></span>
                </span>
                {{ $on ? 'On' : 'Off' }}
            </button>
        </form>
    @endforeach

    <div class="mb-5 flex flex-wrap gap-2">
        <a href="{{ route('admin.articles.index') }}" @class(['rounded-md px-3 py-1.5 text-sm font-medium', 'bg-ocean-950 text-white' => ! $section, 'border border-ocean-100 bg-white text-slate-600 hover:border-ocean-300' => $section])>All</a>
        @foreach (config('agency.sections') as $key => $s)
            <a href="{{ route('admin.articles.index', ['section' => $key]) }}" @class(['rounded-md px-3 py-1.5 text-sm font-medium', 'bg-ocean-950 text-white' => $section === $key, 'border border-ocean-100 bg-white text-slate-600 hover:border-ocean-300' => $section !== $key])>{{ $s['title'] }}</a>
        @endforeach
    </div>

    <div class="overflow-hidden rounded-xl border border-ocean-100 bg-white">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="border-b border-ocean-100 bg-slate-50 text-xs tracking-wide text-slate-500 uppercase">
                    <tr><th class="px-5 py-3 font-semibold">Title</th><th class="px-5 py-3 font-semibold">Section</th><th class="px-5 py-3 font-semibold">Date</th><th class="px-5 py-3 font-semibold">State</th><th class="px-5 py-3"></th></tr>
                </thead>
                <tbody class="divide-y divide-ocean-50">
                    @forelse ($articles as $article)
                        <tr>
                            <td class="px-5 py-3.5">
                                <a href="{{ route('admin.articles.edit', [$article['section'], $article['slug']]) }}" class="font-medium text-ocean-950 hover:text-ocean-600">{{ $article['title'] }}</a>
                                <p class="text-slate-500">/{{ $article['section'] }}/{{ $article['slug'] }}</p>
                            </td>
                            <td class="px-5 py-3.5 whitespace-nowrap text-slate-600">{{ config('agency.sections.'.$article['section'].'.title') }}</td>
                            <td class="px-5 py-3.5 whitespace-nowrap text-slate-600">{{ $article['date']->format('M j, Y') }}</td>
                            <td class="px-5 py-3.5 whitespace-nowrap">
                                @if (! $article['published'])
                                    <span class="rounded-md bg-slate-100 px-2 py-0.5 text-xs font-semibold text-slate-600">{{ ($article['overrides_file'] ?? false) ? 'Hidden' : 'Draft' }}</span>
                                @else
                                    <span class="rounded-md bg-emerald-100 px-2 py-0.5 text-xs font-semibold text-emerald-800">Published</span>
                                @endif
                                @if ($article['source'] === 'file')
                                    <span class="ml-1 text-xs text-slate-400" title="Stored in the site files. Saving it here keeps an edited copy in the database.">Site files</span>
                                @elseif ($article['overrides_file'] ?? false)
                                    <span class="ml-1 text-xs text-slate-400">Edited</span>
                                @endif
                            </td>
                            <td class="px-5 py-3.5">
                                <div class="flex justify-end gap-3 whitespace-nowrap">
                                    @if ($article['published'])
                                        <a href="{{ route('article', [$article['section'], $article['slug']]) }}" target="_blank" class="text-slate-400 hover:text-ocean-600" aria-label="View on site"><x-icon name="eye" class="size-4" /></a>
                                    @endif
                                    <a href="{{ route('admin.articles.edit', [$article['section'], $article['slug']]) }}" class="text-slate-400 hover:text-ocean-600" aria-label="Edit"><x-icon name="pencil" class="size-4" /></a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-5 py-12 text-center text-slate-500">No articles in this section yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-layouts.admin>
