@props(['title', 'lead' => null, 'pageTitle' => null])
<x-layouts.app :title="$pageTitle ?? $title" :noindex="true">
    <section class="bg-sea relative isolate min-h-dvh overflow-hidden pt-36 pb-24 sm:pt-44">
        @include('partials.silk')
        <div class="mx-auto max-w-md px-4 sm:px-6">
            <div class="glass rounded-xl p-6 sm:p-9">
                <h1 class="font-display text-3xl font-semibold tracking-tight text-ocean-950">{{ $title }}</h1>
                @if ($lead)
                    <p class="mt-2 text-sm leading-relaxed text-slate-600">{{ $lead }}</p>
                @endif

                @if (session('status'))
                    <p class="mt-6 rounded-lg border border-ocean-200 bg-ocean-50 px-4 py-3 text-sm text-ocean-900">{{ session('status') }}</p>
                @endif

                <div class="mt-7">
                    {{ $slot }}
                </div>
            </div>
            @isset($footer)
                <p class="mt-6 text-center text-sm text-slate-600">{{ $footer }}</p>
            @endisset
        </div>
    </section>
</x-layouts.app>
