@php $editing = $vacancy->exists; @endphp
<x-layouts.admin :title="$editing ? $vacancy->title : 'New vacancy'">
    <x-slot:header>
        <div>
            <a href="{{ route('admin.vacancies.index') }}" class="inline-flex items-center gap-1.5 text-sm text-slate-500 hover:text-ocean-950"><x-icon name="arrow-left" class="size-4" /> Vacancies</a>
            <h1 class="mt-2 font-display text-3xl font-semibold tracking-tight text-ocean-950">{{ $editing ? 'Edit vacancy' : 'New vacancy' }}</h1>
        </div>
        @if ($editing && $vacancy->published)
            <a href="{{ route('careers.show', $vacancy->slug) }}" target="_blank" class="btn btn-ghost"><x-icon name="eye" class="size-4" /> View on site</a>
        @endif
    </x-slot:header>

    <form method="POST" action="{{ $editing ? route('admin.vacancies.update', $vacancy) : route('admin.vacancies.store') }}" class="grid gap-6 lg:grid-cols-3">
        @csrf
        @if ($editing) @method('PUT') @endif

        <div class="grid content-start gap-5 rounded-xl border border-ocean-100 bg-white p-6 lg:col-span-2">
            <x-auth.input name="title" label="Role title" :value="$vacancy->title" placeholder="e.g. Senior Media Buyer (TikTok)" required />
            <label class="grid gap-2">
                <span class="text-sm font-medium text-slate-700">Summary <span class="font-normal text-slate-500">(one or two sentences for the list and search snippet)</span></span>
                <textarea name="summary" rows="2" maxlength="500" class="field resize-y">{{ old('summary', $vacancy->summary) }}</textarea>
                @error('summary') <span class="text-sm text-rose-600">{{ $message }}</span> @enderror
            </label>
            <label class="grid gap-2">
                <span class="flex justify-between text-sm font-medium text-slate-700">Description <span class="font-normal text-slate-500">Markdown: ## Heading, **bold**, - list</span></span>
                <textarea name="body" rows="20" required class="field resize-y font-mono text-sm leading-relaxed" placeholder="## What you will do&#10;- ...&#10;&#10;## What we expect&#10;- ...&#10;&#10;## What we offer&#10;- ...">{{ old('body', $vacancy->body) }}</textarea>
                @error('body') <span class="text-sm text-rose-600">{{ $message }}</span> @enderror
            </label>
        </div>

        <aside class="grid content-start gap-5">
            <div class="grid gap-5 rounded-xl border border-ocean-100 bg-white p-6">
                <label class="grid gap-2">
                    <span class="text-sm font-medium text-slate-700">Department</span>
                    <select name="department" class="field">
                        @foreach (config('agency.departments') as $key => $d)
                            <option value="{{ $key }}" @selected(old('department', $vacancy->department) === $key)>{{ $d['title'] }}</option>
                        @endforeach
                    </select>
                    @error('department') <span class="text-sm text-rose-600">{{ $message }}</span> @enderror
                </label>
                <label class="grid gap-2">
                    <span class="text-sm font-medium text-slate-700">Employment</span>
                    <select name="employment_type" class="field">
                        @foreach (config('agency.employment_types') as $type)
                            <option @selected(old('employment_type', $vacancy->employment_type) === $type)>{{ $type }}</option>
                        @endforeach
                    </select>
                </label>
                <x-auth.input name="location" label="Location" :value="$vacancy->location" placeholder="Remote, or a city" />
                <x-auth.input name="salary" label="Salary" :value="$vacancy->salary" placeholder="Optional, e.g. $2,000–3,500 + bonus" />
                <x-auth.input name="slug" label="URL slug" :value="$vacancy->slug" placeholder="Generated from the title" :hint="'Shown as /careers/'.($vacancy->slug ?: 'your-slug')" />
                <label class="flex items-center gap-2.5 text-sm font-medium text-slate-700">
                    <input type="hidden" name="published" value="0">
                    <input type="checkbox" name="published" value="1" class="size-4 accent-ocean-600" @checked(old('published', $vacancy->published))> Open (shown on the site)
                </label>
                <button type="submit" class="btn btn-primary">{{ $editing ? 'Save changes' : 'Create vacancy' }}</button>
            </div>
        </aside>
    </form>

    @if ($editing)
        <form method="POST" action="{{ route('admin.vacancies.destroy', $vacancy) }}" class="mt-6" onsubmit="return confirm('Delete this vacancy permanently?')">
            @csrf @method('DELETE')
            <button type="submit" class="inline-flex items-center gap-2 text-sm font-medium text-rose-600 hover:text-rose-800"><x-icon name="trash" class="size-4" /> Delete vacancy</button>
        </form>
    @endif
</x-layouts.admin>
