@props(['id' => 'iw'])
<span {{ $attributes->merge(['class' => 'inline-flex items-center gap-2.5']) }}>
    <x-logo-mark :id="$id" class="h-8 w-11 shrink-0" />
    <span class="flex flex-col">
        <span class="font-display text-[1.2rem] leading-none font-bold tracking-tight text-slate-900">Impact <span class="text-gradient">Waves</span></span>
        <span class="mt-1 text-[.56rem] leading-none font-semibold tracking-[.32em] text-slate-500 uppercase">Media buying agency</span>
    </span>
</span>
