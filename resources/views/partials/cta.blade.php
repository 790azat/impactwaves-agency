<section class="relative pb-24">
    <div class="mx-auto max-w-7xl px-4 sm:px-6">
        <div class="relative isolate overflow-hidden rounded-[2.5rem] bg-brand px-6 py-20 text-center sm:px-16" data-reveal>
            <div class="grid-fade absolute inset-0 -z-10 opacity-60"></div>
            <div class="absolute -bottom-24 left-1/2 -z-10 size-[520px] -translate-x-1/2 rounded-full bg-white/20 blur-3xl"></div>
            <h2 class="mx-auto max-w-3xl font-display text-4xl font-semibold tracking-tight text-white text-balance sm:text-6xl">Ready to make some waves?</h2>
            <p class="mx-auto mt-6 max-w-xl text-lg text-white/85">If you need an effective solution for your business, tell us about your goals. We will come back with a plan.</p>
            <div class="mt-10 flex flex-wrap justify-center gap-4">
                <a href="{{ route('contact') }}" wire:navigate class="btn bg-white text-ink-950 hover:bg-white/90"><x-icon name="rocket" class="size-4" /> Start a project</a>
                <a href="mailto:{{ config('agency.email') }}" class="btn border border-white/40 text-white hover:bg-white/10"><x-icon name="mail" class="size-4" /> {{ config('agency.email') }}</a>
            </div>
        </div>
    </div>
</section>
