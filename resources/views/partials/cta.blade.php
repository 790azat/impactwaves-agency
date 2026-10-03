<section class="bg-sea relative isolate overflow-hidden border-b border-white/10 py-20 sm:py-24">
    <div class="silk silk-hero inset-y-0 right-[-20%] left-[20%] opacity-50 [mask-image:linear-gradient(90deg,transparent,#000_40%)] [background-position:center_70%]" aria-hidden="true"></div>
    <div class="mx-auto flex max-w-7xl flex-col gap-10 px-4 sm:px-6 lg:flex-row lg:items-center lg:justify-between" data-reveal>
        <div>
            <p class="eyebrow">Let's talk</p>
            <h2 class="mt-4 font-display text-4xl font-semibold tracking-tight text-balance sm:text-5xl">Ready to make waves?</h2>
            <p class="mt-4 max-w-2xl text-lg text-slate-300">Let's discuss how we can help you scale your traffic and grow your business.</p>
        </div>
        <div class="flex flex-wrap gap-4">
            <a href="{{ route('contact') }}" wire:navigate class="btn btn-primary">Start a Partnership <x-icon name="arrow" class="size-4" /></a>
            <a href="mailto:{{ config('agency.email') }}" class="btn btn-outline-light"><x-icon name="mail" class="size-4" /> Contact us</a>
        </div>
    </div>
</section>
