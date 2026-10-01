<section class="relative pb-24">
    <div class="mx-auto max-w-7xl px-4 sm:px-6">
        <div class="water relative isolate overflow-hidden rounded-2xl px-6 py-24 text-center sm:px-16" data-reveal>
            @include('partials.caustics', ['fade' => 'linear-gradient(180deg, #000 0%, rgb(0 0 0 / .4) 50%, transparent 100%)', 'opacity' => .5])
            <div class="absolute inset-x-0 bottom-0 -z-10 h-2/3 bg-gradient-to-t from-ocean-950/40 to-transparent"></div>
            @include('partials.bubbles', ['count' => 14, 'rise' => '560px'])
            <h2 class="mx-auto max-w-3xl font-display text-4xl font-semibold tracking-tight text-white text-balance sm:text-6xl">Ready to make some waves?</h2>
            <p class="mx-auto mt-6 max-w-xl text-lg text-white/85">If you need an effective solution for your business, tell us about your goals. We will come back with a plan.</p>
            <div class="mt-10 flex flex-wrap justify-center gap-4">
                <a href="{{ route('contact') }}" wire:navigate class="btn bg-white text-ocean-950 shadow-lg shadow-ocean-950/20 hover:bg-ocean-50"><x-icon name="rocket" class="size-4" /> Start a project</a>
                <a href="mailto:{{ config('agency.email') }}" class="btn border border-white/40 text-white hover:bg-white/10"><x-icon name="mail" class="size-4" /> {{ config('agency.email') }}</a>
            </div>
        </div>
    </div>
</section>
