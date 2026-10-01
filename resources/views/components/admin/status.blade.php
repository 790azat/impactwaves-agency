@props(['status'])
@php
    $styles = [
        'new' => 'bg-ocean-600 text-white',
        'contacted' => 'bg-ocean-100 text-ocean-800',
        'qualified' => 'bg-cyan-100 text-cyan-800',
        'won' => 'bg-emerald-100 text-emerald-800',
        'lost' => 'bg-slate-100 text-slate-600',
        'spam' => 'bg-rose-100 text-rose-700',
    ];
@endphp
<span {{ $attributes->merge(['class' => 'inline-flex items-center rounded-md px-2 py-0.5 text-xs font-semibold '.($styles[$status] ?? $styles['lost'])]) }}>{{ \App\Models\Lead::STATUSES[$status] ?? ucfirst($status) }}</span>
