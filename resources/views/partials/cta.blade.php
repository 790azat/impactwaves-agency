<section class="relative pb-24">
    <div class="mx-auto max-w-7xl px-4 sm:px-6">
        <div class="bg-deep relative isolate overflow-hidden rounded-[2.5rem] px-6 pt-28 pb-20 text-center sm:px-16" data-reveal>
            {{-- The surface seen from below. --}}
            <div class="absolute inset-x-0 top-0 -z-10 rotate-180">
                @include('partials.sea-waves', ['id' => 'cta-wave', 'fill' => 'rgb(255 255 255 / .9)', 'tint' => '255 255 255', 'class' => 'h-16 sm:h-20'])
            </div>
            @include('partials.bubbles', ['count' => 14, 'color' => 'border-white/50 bg-white/15'])
            <h2 class="mx-auto max-w-3xl font-display text-4xl font-semibold tracking-tight text-white text-balance sm:text-6xl">Ready to make some waves?</h2>
            <p class="mx-auto mt-6 max-w-xl text-lg text-white/85">If you need an effective solution for your business, tell us about your goals. We will come back with a plan.</p>
            <div class="mt-10 flex flex-wrap justify-center gap-4">
                <a href="{{ route('contact') }}" wire:navigate class="btn bg-white text-ocean-950 shadow-lg shadow-ocean-950/20 hover:bg-ocean-50"><x-icon name="rocket" class="size-4" /> Start a project</a>
                <a href="mailto:{{ config('agency.email') }}" class="btn border border-white/40 text-white hover:bg-white/10"><x-icon name="mail" class="size-4" /> {{ config('agency.email') }}</a>
            </div>
        </div>
    </div>
</section>
