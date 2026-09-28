<x-layouts.app title="Page not found">
    <section class="relative isolate grid min-h-[80vh] place-items-center overflow-hidden px-4 pt-32 text-center">
        <div class="grid-fade absolute inset-0 -z-10"></div>
        <div>
            <x-logo-mark id="nf" class="mx-auto size-20" />
            <p class="mt-8 font-display text-8xl font-semibold text-gradient">404</p>
            <h1 class="mt-4 font-display text-3xl font-semibold text-white">This wave didn't reach the shore</h1>
            <p class="mt-3 text-slate-400">The page you are looking for doesn't exist or has moved.</p>
            <div class="mt-8 flex justify-center gap-3">
                <x-button href="{{ route('home') }}">Back home</x-button>
                <x-button href="{{ route('contact') }}" variant="ghost">Contact us</x-button>
            </div>
        </div>
    </section>
</x-layouts.app>
