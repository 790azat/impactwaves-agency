{{-- Departments grid. Head counts come from Admin → Company. --}}
@php
    $departments = \App\Support\Company::departments();
@endphp
<div class="grid gap-px overflow-hidden rounded-2xl border border-ocean-100 bg-ocean-100 sm:grid-cols-2 lg:grid-cols-3">
    @foreach ($departments as $department)
        <div class="bg-white p-7" data-reveal style="--reveal-delay: {{ $loop->index * 60 }}ms">
            <div class="flex items-start justify-between gap-4">
                <h3 class="font-display text-lg font-semibold text-ocean-950">{{ $department['title'] }}</h3>
                @if ($department['size'])
                    <span class="text-right"><span class="block font-display text-3xl font-semibold text-ocean-950">{{ $department['size'] }}</span><span class="text-xs text-slate-500">{{ $department['note'] ?? ($department['size'] == 1 ? 'person' : 'people') }}</span></span>
                @endif
            </div>
            <p class="mt-2 text-sm leading-relaxed text-slate-600">{{ $department['text'] }}</p>
        </div>
    @endforeach
</div>
