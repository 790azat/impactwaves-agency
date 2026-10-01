<x-layouts.admin :title="$lead->name">
    <x-slot:header>
        <div>
            <a href="{{ route('admin.leads.index') }}" class="inline-flex items-center gap-1.5 text-sm text-slate-500 hover:text-ocean-950"><x-icon name="arrow-left" class="size-4" /> Leads</a>
            <h1 class="mt-2 font-display text-3xl font-semibold tracking-tight text-ocean-950">{{ $lead->name }}</h1>
            <p class="mt-1.5 text-sm text-slate-600">Received {{ $lead->created_at->format('M j, Y \a\t H:i') }} UTC</p>
        </div>
        <a href="mailto:{{ $lead->email }}?subject={{ rawurlencode('Re: your request to Impact Waves') }}" class="btn btn-primary"><x-icon name="mail" class="size-4" /> Reply by email</a>
    </x-slot:header>

    <div class="grid gap-6 lg:grid-cols-3">
        <section class="rounded-xl border border-ocean-100 bg-white p-6 lg:col-span-2">
            <dl class="grid gap-5 sm:grid-cols-2">
                <div><dt class="text-xs font-semibold tracking-wide text-slate-500 uppercase">Email</dt><dd class="mt-1 text-ocean-950"><a href="mailto:{{ $lead->email }}" class="hover:text-ocean-600">{{ $lead->email }}</a></dd></div>
                <div><dt class="text-xs font-semibold tracking-wide text-slate-500 uppercase">Company</dt><dd class="mt-1 text-ocean-950">{{ $lead->company ?: '—' }}</dd></div>
                <div><dt class="text-xs font-semibold tracking-wide text-slate-500 uppercase">Budget</dt><dd class="mt-1 text-ocean-950">{{ $lead->budgetLabel() ?: '—' }}</dd></div>
                <div><dt class="text-xs font-semibold tracking-wide text-slate-500 uppercase">Account</dt><dd class="mt-1 text-ocean-950">{{ $lead->user ? 'Registered user' : 'Guest' }}</dd></div>
                <div class="sm:col-span-2"><dt class="text-xs font-semibold tracking-wide text-slate-500 uppercase">Services</dt>
                    <dd class="mt-2 flex flex-wrap gap-2">@foreach ($lead->serviceTitles() as $title)<span class="rounded-md bg-ocean-50 px-2.5 py-1 text-sm text-ocean-800">{{ $title }}</span>@endforeach</dd></div>
            </dl>
            <div class="mt-6 border-t border-ocean-100 pt-6">
                <h2 class="text-xs font-semibold tracking-wide text-slate-500 uppercase">Message</h2>
                <p class="mt-3 leading-relaxed whitespace-pre-line text-slate-700">{{ $lead->message }}</p>
            </div>
        </section>

        <aside class="grid content-start gap-6">
            <form method="POST" action="{{ route('admin.leads.update', $lead) }}" class="grid gap-4 rounded-xl border border-ocean-100 bg-white p-6">
                @csrf @method('PUT')
                <label class="grid gap-2">
                    <span class="text-sm font-medium text-slate-700">Status</span>
                    <select name="status" class="field !rounded-lg">
                        @foreach (\App\Models\Lead::STATUSES as $key => $label)
                            <option value="{{ $key }}" @selected($lead->status === $key)>{{ $label }}</option>
                        @endforeach
                    </select>
                </label>
                <label class="grid gap-2">
                    <span class="text-sm font-medium text-slate-700">Internal notes</span>
                    <textarea name="notes" rows="5" class="field !rounded-lg resize-y text-sm" placeholder="Visible to admins only">{{ old('notes', $lead->notes) }}</textarea>
                </label>
                <button type="submit" class="btn btn-primary">Save</button>
            </form>

            <form method="POST" action="{{ route('admin.leads.destroy', $lead) }}" onsubmit="return confirm('Delete this lead permanently?')">
                @csrf @method('DELETE')
                <button type="submit" class="inline-flex items-center gap-2 text-sm font-medium text-rose-600 hover:text-rose-800"><x-icon name="trash" class="size-4" /> Delete lead</button>
            </form>
        </aside>
    </div>
</x-layouts.admin>
