@props(['name', 'label', 'type' => 'text', 'value' => null, 'bag' => 'default', 'hint' => null])
<label class="grid gap-2">
    <span class="flex justify-between text-sm font-medium text-slate-700">{{ $label }} @isset($aside){{ $aside }}@endisset</span>
    <input type="{{ $type }}" name="{{ $name }}" @if ($type !== 'password') value="{{ old($name, $value) }}" @endif
           {{ $attributes->merge(['class' => 'field']) }}>
    @if ($hint)
        <span class="text-xs text-slate-500">{{ $hint }}</span>
    @endif
    @error($name, $bag) <span class="text-sm text-rose-600">{{ $message }}</span> @enderror
</label>
