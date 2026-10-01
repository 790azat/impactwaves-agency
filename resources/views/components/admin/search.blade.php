@props(['value' => '', 'placeholder' => 'Search'])
<form method="GET" class="relative w-full sm:w-72">
    @foreach (request()->except(['q', 'page']) as $key => $val)
        <input type="hidden" name="{{ $key }}" value="{{ $val }}">
    @endforeach
    <x-icon name="search" class="pointer-events-none absolute top-1/2 left-3.5 size-4 -translate-y-1/2 text-slate-400" />
    <input type="search" name="q" value="{{ $value }}" placeholder="{{ $placeholder }}" class="field !rounded-lg !py-2.5 !pl-10 text-sm">
</form>
