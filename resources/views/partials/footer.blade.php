<footer class="relative mt-16 border-t border-ocean-100 bg-ocean-50">
    <div class="mx-auto max-w-7xl px-4 pt-10 pb-14 sm:px-6">
        <div class="grid gap-12 lg:grid-cols-12">
            <div class="lg:col-span-5">
                <x-logo class="h-8 w-auto" />
                <p class="mt-5 max-w-sm leading-relaxed text-slate-600">{{ config('agency.tagline') }} Data-driven performance marketing for brands and media buyers across the US, EU and Canada.</p>
                <div class="mt-6 flex flex-wrap gap-3">
                    <a href="mailto:{{ config('agency.email') }}" class="btn btn-ghost !px-4 !py-2.5"><x-icon name="mail" class="size-4" /> {{ config('agency.email') }}</a>
                    <a href="{{ config('agency.linkedin') }}" target="_blank" rel="noopener" class="btn btn-ghost !px-4 !py-2.5" aria-label="LinkedIn">
                        <svg class="size-4" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M20.45 20.45h-3.56v-5.57c0-1.33-.02-3.04-1.85-3.04-1.85 0-2.14 1.45-2.14 2.94v5.67H9.35V9h3.41v1.56h.05c.48-.9 1.64-1.85 3.37-1.85 3.6 0 4.27 2.37 4.27 5.46v6.28ZM5.34 7.43a2.06 2.06 0 1 1 0-4.13 2.06 2.06 0 0 1 0 4.13ZM7.12 20.45H3.56V9h3.56v11.45ZM22.22 0H1.77C.8 0 0 .77 0 1.73v20.54C0 23.23.8 24 1.77 24h20.45c.98 0 1.78-.77 1.78-1.73V1.73C24 .77 23.2 0 22.22 0Z"/></svg>
                        LinkedIn
                    </a>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-8 sm:grid-cols-3 lg:col-span-7">
                <div>
                    <h3 class="text-sm font-semibold text-ocean-950">Services</h3>
                    <ul class="mt-4 space-y-3 text-sm">
                        @foreach (config('agency.services') as $slug => $service)
                            <li><a href="{{ route('services.show', $slug) }}" wire:navigate class="text-slate-600 transition hover:text-ocean-950">{{ $service['title'] }}</a></li>
                        @endforeach
                    </ul>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-ocean-950">Company</h3>
                    <ul class="mt-4 space-y-3 text-sm">
                        <li><a href="{{ route('about') }}" wire:navigate class="text-slate-600 transition hover:text-ocean-950">About</a></li>
                        @foreach (config('agency.sections') as $key => $section)
                            <li><a href="{{ route('section', $key) }}" wire:navigate class="text-slate-600 transition hover:text-ocean-950">{{ $section['title'] }}</a></li>
                        @endforeach
                        <li><a href="{{ route('home') }}#partners" class="text-slate-600 transition hover:text-ocean-950">Partners</a></li>
                        <li><a href="{{ route('home') }}#calculator" class="text-slate-600 transition hover:text-ocean-950">ROI calculator</a></li>
                        <li><a href="{{ route('contact') }}" wire:navigate class="text-slate-600 transition hover:text-ocean-950">Contact</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-ocean-950">Markets</h3>
                    <ul class="mt-4 space-y-3 text-sm">
                        @foreach (config('agency.markets') as $market)
                            <li class="flex items-center gap-2 text-slate-600"><span class="rounded-md bg-ocean-50 px-1.5 py-0.5 font-mono text-[11px] text-ocean-600">{{ $market['code'] }}</span>{{ $market['name'] }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
    {{-- The shore. --}}
    <div class="border-t border-sand-200/70 bg-sand-100">
        <div class="mx-auto flex max-w-7xl flex-col gap-3 px-4 py-6 text-sm text-slate-500 sm:flex-row sm:items-center sm:justify-between sm:px-6">
            <p>&copy; {{ date('Y') }} {{ config('agency.legal_name') }}. All rights reserved.</p>
            <p>Made to make waves.</p>
        </div>
    </div>
</footer>
