<x-layouts.admin title="Services">
    <x-slot:header>
        <x-admin.heading title="Services" lead="Texts of the service pages, the services list on the home page and the contact form." />
    </x-slot:header>

    <div class="overflow-hidden rounded-xl border border-ocean-100 bg-white">
        <ul class="divide-y divide-ocean-50">
            @foreach ($services as $slug => $service)
                <li class="flex items-center justify-between gap-4 px-5 py-4">
                    <a href="{{ route('admin.services.edit', $slug) }}" class="flex min-w-0 items-center gap-4">
                        <x-icon :name="$service['icon']" class="size-5 shrink-0 text-ocean-500" />
                        <span class="min-w-0">
                            <span class="block font-medium text-ocean-950 hover:text-ocean-600">{{ $service['title'] }}</span>
                            <span class="block truncate text-sm text-slate-500">{{ $service['short'] }}</span>
                        </span>
                    </a>
                    <span class="flex shrink-0 items-center gap-3">
                        @if (isset($edited[$slug]))<span class="text-xs text-slate-400">Edited</span>@endif
                        <a href="{{ route('services.show', $slug) }}" target="_blank" class="text-slate-400 hover:text-ocean-600" aria-label="View on site"><x-icon name="eye" class="size-4" /></a>
                        <a href="{{ route('admin.services.edit', $slug) }}" class="text-slate-400 hover:text-ocean-600" aria-label="Edit"><x-icon name="pencil" class="size-4" /></a>
                    </span>
                </li>
            @endforeach
        </ul>
    </div>
    <p class="mt-4 text-sm text-slate-500">Guides and Traffic Providers texts are articles: edit them in <a href="{{ route('admin.articles.index') }}" class="text-ocean-600 hover:text-ocean-800">Articles</a>.</p>
</x-layouts.admin>
