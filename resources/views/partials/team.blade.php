{{-- Departments grid. Head counts come from Admin → Company. --}}
@php
    $departments = \App\Support\Company::departments();
    $total = \App\Support\Company::teamSize();
@endphp
<div class="grid gap-px overflow-hidden rounded-2xl border border-ocean-100 bg-ocean-100 sm:grid-cols-2 lg:grid-cols-3">
    @foreach ($departments as $department)
        <div class="bg-white p-7" data-reveal style="--reveal-delay: {{ $loop->index * 60 }}ms">
            <div class="flex items-start justify-between gap-4">
                <span class="grid size-11 place-items-center rounded-lg border border-ocean-100 bg-ocean-50"><x-icon :name="$department['icon']" class="size-5 text-ocean-700" /></span>
                @if ($department['size'])
                    <span class="text-right"><span class="block font-display text-3xl font-semibold text-ocean-950">{{ $department['size'] }}</span><span class="text-xs text-slate-500">{{ $department['size'] == 1 ? 'person' : 'people' }}</span></span>
                @endif
            </div>
            <h3 class="mt-5 font-display text-lg font-semibold text-ocean-950">{{ $department['title'] }}</h3>
            <p class="mt-2 text-sm leading-relaxed text-slate-600">{{ $department['text'] }}</p>
        </div>
    @endforeach
</div>
@if ($total)
    <p class="mt-5 text-sm text-slate-500">{{ $total }} people across {{ count($departments) }} departments, all in-house.</p>
@endif
