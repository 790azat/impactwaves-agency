@php $features = array_pad(old('features', $service['features']), count($service['features']) + 3, ['title' => '', 'text' => '']); @endphp
<x-layouts.admin :title="$service['title']">
    <x-slot:header>
        <div>
            <a href="{{ route('admin.services.index') }}" class="inline-flex items-center gap-1.5 text-sm text-slate-500 hover:text-ocean-950"><x-icon name="arrow-left" class="size-4" /> Services</a>
            <h1 class="mt-2 font-display text-3xl font-semibold tracking-tight text-ocean-950">{{ $service['title'] }}</h1>
        </div>
        <a href="{{ route('services.show', $slug) }}" target="_blank" class="btn btn-ghost"><x-icon name="eye" class="size-4" /> View on site</a>
    </x-slot:header>

    <form method="POST" action="{{ route('admin.services.update', $slug) }}" class="grid gap-6 lg:grid-cols-3">
        @csrf @method('PUT')

        <div class="grid content-start gap-5 rounded-xl border border-ocean-100 bg-white p-6 lg:col-span-2">
            <x-auth.input name="headline" label="Page headline" :value="$service['headline']" required />
            <label class="grid gap-2">
                <span class="text-sm font-medium text-slate-700">Intro <span class="font-normal text-slate-500">(paragraph under the headline)</span></span>
                <textarea name="intro" rows="5" required class="field resize-y">{{ old('intro', $service['intro']) }}</textarea>
                @error('intro') <span class="text-sm text-rose-600">{{ $message }}</span> @enderror
            </label>
            <div class="grid gap-3">
                <span class="text-sm font-medium text-slate-700">What's included <span class="font-normal text-slate-500">(leave a title empty to remove a point)</span></span>
                @foreach ($features as $i => $feature)
                    <div class="grid gap-2 rounded-lg border border-ocean-50 bg-slate-50 p-3 sm:grid-cols-[1fr_2fr]">
                        <input name="features[{{ $i }}][title]" value="{{ $feature['title'] }}" class="field" placeholder="Title" aria-label="Point {{ $i + 1 }} title">
                        <textarea name="features[{{ $i }}][text]" rows="2" class="field resize-y" placeholder="Description" aria-label="Point {{ $i + 1 }} description">{{ $feature['text'] }}</textarea>
                    </div>
                @endforeach
            </div>
        </div>

        <aside class="grid content-start gap-5">
            <div class="grid gap-5 rounded-xl border border-ocean-100 bg-white p-6">
                <x-auth.input name="title" label="Name" :value="$service['title']" required />
                <x-auth.input name="eyebrow" label="Label" :value="$service['eyebrow']" hint="Small label above the title, e.g. Social." />
                <label class="grid gap-2">
                    <span class="text-sm font-medium text-slate-700">Short description <span class="font-normal text-slate-500">(cards and search snippet)</span></span>
                    <textarea name="short" rows="3" required maxlength="300" class="field resize-y">{{ old('short', $service['short']) }}</textarea>
                    @error('short') <span class="text-sm text-rose-600">{{ $message }}</span> @enderror
                </label>
                <x-auth.input name="platforms" label="Platforms" :value="implode(', ', $service['platforms'])" hint="Comma separated." />
                <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
        </aside>
    </form>

    @if ($edited)
        <form method="POST" action="{{ route('admin.services.destroy', $slug) }}" class="mt-6" onsubmit="return confirm('Discard your edits and restore the original text?')">
            @csrf @method('DELETE')
            <button type="submit" class="inline-flex items-center gap-2 text-sm font-medium text-rose-600 hover:text-rose-800"><x-icon name="refresh" class="size-4" /> Restore original text</button>
        </form>
    @endif
</x-layouts.admin>
