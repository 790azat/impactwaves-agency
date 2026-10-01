<x-layouts.app title="Contact" description="Tell Impact Waves about your goals and get a growth plan for paid social, PPC, CRO, TikTok or search feeds.">
    <section class="relative isolate overflow-hidden pt-40 pb-24 sm:pt-48">
        @include('partials.caustics', ['tint' => true, 'fade' => 'radial-gradient(ellipse 70% 70% at 70% 10%, #000 15%, transparent 70%)'])
        <div class="absolute -top-48 left-1/3 -z-10 h-[560px] w-[900px] rounded-md bg-[radial-gradient(closest-side,rgb(45_212_191/.22),transparent)] blur-2xl"></div>
        <div class="mx-auto grid max-w-7xl gap-14 px-4 sm:px-6 lg:grid-cols-12">
            <div class="lg:col-span-5">
                <p class="eyebrow" data-reveal>Contact</p>
                <h1 class="mt-6 font-display text-5xl leading-[1.05] font-semibold tracking-tight text-ocean-950 sm:text-6xl" data-reveal>Let's make <span class="text-gradient">an impact</span></h1>
                <p class="mt-6 text-lg leading-relaxed text-slate-600" data-reveal>If you need an effective solution for your business, tell us where you are and where you want to go. We will reply with next steps and a plan.</p>
                <ul class="mt-10 space-y-5" data-reveal>
                    @foreach (['A free audit of your current accounts and tracking', 'A channel and budget recommendation for your goals', 'Direct access to the team that runs your campaigns'] as $point)
                        <li class="flex gap-3"><span class="mt-0.5 grid size-6 shrink-0 place-items-center rounded-full bg-brand text-white"><x-icon name="check" class="size-3.5" /></span><span class="text-slate-700">{{ $point }}</span></li>
                    @endforeach
                </ul>
                <div class="mt-12 space-y-3 border-t border-ocean-100 pt-8" data-reveal>
                    <a href="mailto:{{ config('agency.email') }}" class="flex items-center gap-3 text-ocean-950 hover:text-ocean-600"><x-icon name="mail" class="size-5 text-slate-600" /> {{ config('agency.email') }}</a>
                    <a href="{{ config('agency.linkedin') }}" target="_blank" rel="noopener" class="flex items-center gap-3 text-ocean-950 hover:text-ocean-600"><x-icon name="arrow-up-right" class="size-5 text-slate-600" /> LinkedIn: Impact Waves Agency</a>
                    @if ($place = \App\Support\Company::place())
                        @php $location = \App\Support\Company::location(); @endphp
                        <p class="flex items-start gap-3 text-ocean-950"><x-icon name="map-pin" class="mt-0.5 size-5 shrink-0 text-slate-600" /> <span>{{ $location['address'] ? $location['address'].', ' : '' }}{{ $place }}@if ($location['note'])<span class="mt-1 block text-sm text-slate-500">{{ $location['note'] }}</span>@endif</span></p>
                    @endif
                </div>
            </div>
            <div class="lg:col-span-7" data-reveal style="--reveal-delay:120ms">
                <livewire:contact-form :service="request('service')" />
            </div>
        </div>
    </section>
</x-layouts.app>
