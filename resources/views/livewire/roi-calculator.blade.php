@use('App\Livewire\RoiCalculator')
@php
    $cur = $this->current;
    $opt = $this->optimized;
    $extra = $opt['revenue'] - $cur['revenue'];
    $sliders = [
        ['budget', 'Monthly ad spend', 1000, 500000, 1000, RoiCalculator::money($budget)],
        ['cpc', 'Average cost per click', 0.1, 10, 0.05, '$'.number_format($cpc, 2)],
        ['conversionRate', 'Conversion rate', 0.3, 15, 0.1, number_format($conversionRate, 1).'%'],
        ['orderValue', 'Average order value', 5, 2000, 5, '$'.number_format($orderValue)],
        ['uplift', 'Conversion lift from CRO', 0, 100, 5, '+'.$uplift.'%'],
    ];
@endphp
<div class="grid gap-5 lg:grid-cols-12">
    <div class="glass rounded-[2rem] p-6 sm:p-10 lg:col-span-7">
        <div class="grid gap-8">
            @foreach ($sliders as [$prop, $label, $min, $max, $step, $display])
                <label class="grid gap-3" wire:key="slider-{{ $prop }}">
                    <span class="flex items-baseline justify-between gap-4">
                        <span class="text-sm font-medium text-slate-300">{{ $label }}</span>
                        <span class="font-display text-xl font-semibold text-white tabular-nums">{{ $display }}</span>
                    </span>
                    <input type="range" class="range w-full" min="{{ $min }}" max="{{ $max }}" step="{{ $step }}"
                           wire:model.live.debounce.120ms="{{ $prop }}" aria-label="{{ $label }}">
                </label>
            @endforeach
        </div>
        <p class="mt-8 text-xs leading-relaxed text-slate-500">Estimates for illustration only. Real results depend on your market, offer, creative and tracking.</p>
    </div>

    <div class="relative isolate overflow-hidden rounded-[2rem] border border-white/10 bg-ink-900 p-6 sm:p-10 lg:col-span-5">
        <div class="absolute -top-20 -right-20 -z-10 size-72 rounded-full bg-fuchsia-500/25 blur-3xl"></div>
        <div class="absolute -bottom-20 -left-20 -z-10 size-72 rounded-full bg-cyan-400/20 blur-3xl"></div>

        <div class="flex items-center justify-between">
            <p class="text-sm font-medium text-slate-400">Extra monthly revenue with CRO</p>
            <span wire:loading.delay class="size-2 animate-pulse rounded-full bg-cyan-300"></span>
        </div>
        <p class="mt-2 font-display text-5xl font-semibold tracking-tight text-gradient tabular-nums sm:text-6xl">+{{ RoiCalculator::money($extra) }}</p>

        <div class="mt-8 grid grid-cols-2 gap-3">
            @foreach ([
                ['Clicks', number_format($cur['clicks'])],
                ['Conversions', number_format($cur['conversions']).' → '.number_format($opt['conversions'])],
                ['ROAS', number_format($cur['roas'], 2).'x → '.number_format($opt['roas'], 2).'x'],
                ['Cost per acquisition', RoiCalculator::money($cur['cpa']).' → '.RoiCalculator::money($opt['cpa'])],
            ] as [$label, $value])
                <div class="rounded-2xl border border-white/10 bg-white/[.03] p-4">
                    <p class="text-xs text-slate-500">{{ $label }}</p>
                    <p class="mt-1 font-semibold text-white tabular-nums">{{ $value }}</p>
                </div>
            @endforeach
        </div>

        @php $max = max($opt['revenue'], $budget, 1); @endphp
        <div class="mt-8 space-y-4">
            @foreach ([
                ['Ad spend', $budget, 'bg-white/25'],
                ['Revenue today', $cur['revenue'], 'bg-gradient-to-r from-cyan-400 to-indigo-500'],
                ['Revenue with CRO', $opt['revenue'], 'bg-brand'],
            ] as [$label, $value, $color])
                <div>
                    <div class="flex justify-between text-xs"><span class="text-slate-400">{{ $label }}</span><span class="font-medium text-white tabular-nums">{{ RoiCalculator::money($value) }}</span></div>
                    <div class="mt-1.5 h-2.5 overflow-hidden rounded-full bg-white/5">
                        <div class="{{ $color }} h-full rounded-full transition-all duration-500 ease-out" style="width: {{ max(2, $value / $max * 100) }}%"></div>
                    </div>
                </div>
            @endforeach
        </div>

        <a href="{{ route('contact') }}?service=cro" wire:navigate class="btn btn-primary mt-10 w-full">Get a CRO audit</a>
    </div>
</div>
