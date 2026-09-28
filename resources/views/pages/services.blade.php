<x-layouts.app title="Services" description="Paid social, PPC, CRO, official TikTok agency accounts and Tier-1 search feed monetization.">
    @include('partials.page-hero', [
        'eyebrow' => 'Services',
        'title' => 'Everything you need to <span class="text-gradient">grow with paid media</span>',
        'lead' => 'One data-driven team for acquisition, conversion and monetization. Pick a single service or combine them into a full-funnel program.',
    ])

    <section class="pb-24">
        <div class="mx-auto grid max-w-7xl gap-5 px-4 sm:px-6">
            @foreach (config('agency.services') as $slug => $service)
                <a href="{{ route('services.show', $slug) }}" wire:navigate data-reveal
                   class="card-glow group glass grid gap-8 rounded-3xl p-8 transition duration-500 hover:-translate-y-0.5 sm:p-10 lg:grid-cols-12 lg:items-center">
                    <div class="flex items-center gap-5 lg:col-span-5">
                        <span class="font-display text-sm text-slate-500">0{{ $loop->iteration }}</span>
                        <span class="grid size-14 shrink-0 place-items-center rounded-2xl bg-gradient-to-br from-cyan-400/20 to-fuchsia-500/20 text-indigo-600 ring-1 ring-slate-200">
                            <x-icon :name="$service['icon']" class="size-7" />
                        </span>
                        <div>
                            <p class="text-xs font-medium tracking-[.14em] text-cyan-700 uppercase">{{ $service['eyebrow'] }}</p>
                            <h2 class="mt-1 font-display text-2xl font-semibold text-slate-900 sm:text-3xl">{{ $service['title'] }}</h2>
                        </div>
                    </div>
                    <p class="leading-relaxed text-slate-600 lg:col-span-5">{{ $service['short'] }}</p>
                    <div class="flex justify-end lg:col-span-2">
                        <span class="grid size-12 place-items-center rounded-full border border-slate-200 text-slate-900 transition duration-300 group-hover:text-white group-hover:bg-brand group-hover:border-transparent">
                            <x-icon name="arrow-up-right" class="size-5" />
                        </span>
                    </div>
                </a>
            @endforeach
        </div>
    </section>

    @include('partials.cta')
</x-layouts.app>
