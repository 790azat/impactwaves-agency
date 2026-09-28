@props(['id' => 'iw'])
<span {{ $attributes->merge(['class' => 'inline-flex items-center gap-2.5']) }}>
    <x-logo-mark :id="$id" class="size-9 shrink-0" />
    <span class="font-display text-[1.15rem] leading-none font-semibold tracking-tight text-slate-900">
        impact<span class="text-gradient">waves</span>
    </span>
</span>
