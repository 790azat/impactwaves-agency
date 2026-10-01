@php
    $place = \App\Support\Company::place();
    $remote = $vacancy->location && str_contains(strtolower($vacancy->location), 'remote');
    $apply = 'mailto:'.config('agency.careers_email').'?subject='.rawurlencode('Application: '.$vacancy->title);
    $types = ['Full-time' => 'FULL_TIME', 'Part-time' => 'PART_TIME', 'Contract' => 'CONTRACTOR', 'Internship' => 'INTERN'];
@endphp
<x-layouts.app :title="$vacancy->title.' · Careers'" :description="$vacancy->summary ?: $vacancy->title.' at '.config('agency.legal_name').'.'">
    @push('schema')
        <script type="application/ld+json">
            {!! json_encode(array_filter([
                "\x40context" => 'https://schema.org',
                "\x40type" => 'JobPosting',
                'title' => $vacancy->title,
                'description' => $vacancy->html(),
                'datePosted' => $vacancy->created_at->toDateString(),
                'employmentType' => $types[$vacancy->employment_type] ?? null,
                'hiringOrganization' => ["\x40type" => 'Organization', 'name' => config('agency.legal_name'), 'sameAs' => route('home'), 'logo' => url('/logo.png')],
                'jobLocationType' => $remote ? 'TELECOMMUTE' : null,
                'jobLocation' => ! $remote && ($vacancy->location || $place) ? ["\x40type" => 'Place', 'address' => ["\x40type" => 'PostalAddress', 'addressLocality' => $vacancy->location ?: $place]] : null,
                'occupationalCategory' => $vacancy->departmentTitle(),
            ]), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
        </script>
    @endpush

    <article>
        <header class="bg-sea relative isolate overflow-hidden border-b border-ocean-100 pt-36 pb-16 sm:pt-44 sm:pb-20">
            @include('partials.caustics', ['tint' => true, 'fade' => 'radial-gradient(ellipse 70% 80% at 80% 10%, #000 15%, transparent 70%)'])
            <div class="mx-auto max-w-6xl px-4 sm:px-6">
                <nav aria-label="Breadcrumb" class="text-sm text-slate-500" data-reveal>
                    <ol class="flex flex-wrap items-center gap-2">
                        <li><a href="{{ route('home') }}" wire:navigate class="hover:text-ocean-950">Home</a></li>
                        <li aria-hidden="true">/</li>
                        <li><a href="{{ route('careers') }}" wire:navigate class="hover:text-ocean-950">Careers</a></li>
                    </ol>
                </nav>
                <p class="eyebrow mt-6" data-reveal><x-icon name="briefcase" class="size-4" /> {{ $vacancy->departmentTitle() }}</p>
                <h1 class="mt-6 font-display text-4xl leading-[1.1] font-semibold tracking-tight text-ocean-950 text-balance sm:text-5xl" data-reveal style="--reveal-delay:80ms">{{ $vacancy->title }}</h1>
                @if ($vacancy->summary)
                    <p class="mt-6 max-w-3xl text-lg leading-relaxed text-slate-600 text-pretty sm:text-xl" data-reveal style="--reveal-delay:140ms">{{ $vacancy->summary }}</p>
                @endif
                <div class="mt-8 flex flex-wrap items-center gap-2 text-sm text-slate-600" data-reveal style="--reveal-delay:200ms">
                    @if ($vacancy->location)<span class="inline-flex items-center gap-1.5 rounded-md border border-ocean-100 bg-white px-2.5 py-1"><x-icon name="map-pin" class="size-4 text-ocean-500" /> {{ $vacancy->location }}</span>@endif
                    <span class="inline-flex items-center gap-1.5 rounded-md border border-ocean-100 bg-white px-2.5 py-1"><x-icon name="clock" class="size-4 text-ocean-500" /> {{ $vacancy->employment_type }}</span>
                    @if ($vacancy->salary)<span class="inline-flex items-center gap-1.5 rounded-md border border-ocean-100 bg-white px-2.5 py-1"><x-icon name="chart" class="size-4 text-ocean-500" /> {{ $vacancy->salary }}</span>@endif
                </div>
            </div>
        </header>

        <div class="mx-auto grid max-w-6xl gap-12 px-4 py-16 sm:px-6 lg:grid-cols-[1fr_280px]">
            <div class="prose-article min-w-0">{!! $vacancy->html() !!}</div>
            <aside>
                <div class="sticky top-28 rounded-2xl border border-ocean-100 bg-ocean-50 p-6">
                    <h2 class="font-display text-lg font-semibold text-ocean-950">Interested?</h2>
                    <p class="mt-2 text-sm leading-relaxed text-slate-600">Send your CV or portfolio and a few lines about your experience.</p>
                    <a href="{{ $apply }}" class="btn btn-primary mt-5 w-full"><x-icon name="send" class="size-4" /> Apply</a>
                    <p class="mt-3 text-center text-xs text-slate-500">{{ config('agency.careers_email') }}</p>
                </div>
            </aside>
        </div>
    </article>

    @if ($others->isNotEmpty())
        <section class="pb-20">
            <div class="mx-auto max-w-6xl px-4 sm:px-6">
                <h2 class="font-display text-2xl font-semibold text-ocean-950">Other open roles</h2>
                <ul class="mt-6 grid gap-4 sm:grid-cols-3">
                    @foreach ($others as $other)
                        <li><a href="{{ route('careers.show', $other->slug) }}" wire:navigate class="block rounded-xl border border-ocean-100 bg-white p-5 transition hover:border-ocean-300">
                            <p class="text-sm text-ocean-600">{{ $other->departmentTitle() }}</p>
                            <p class="mt-1 font-display font-semibold text-ocean-950">{{ $other->title }}</p>
                        </a></li>
                    @endforeach
                </ul>
            </div>
        </section>
    @endif
</x-layouts.app>
