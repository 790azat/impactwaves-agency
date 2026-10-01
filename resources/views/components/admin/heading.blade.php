@props(['title', 'lead' => null])
<div>
    <h1 class="font-display text-3xl font-semibold tracking-tight text-ocean-950">{{ $title }}</h1>
    @if ($lead)<p class="mt-1.5 text-sm text-slate-600">{{ $lead }}</p>@endif
</div>
