<x-layouts.admin title="Company">
    <x-slot:header>
        <x-admin.heading title="Company" lead="Location and team sizes shown on About, Careers, Contact and in the footer." />
    </x-slot:header>

    <form method="POST" action="{{ route('admin.company.update') }}" class="grid gap-6 lg:grid-cols-2">
        @csrf @method('PUT')

        <section class="grid content-start gap-5 rounded-xl border border-ocean-100 bg-white p-6">
            <div>
                <h2 class="font-display font-semibold text-ocean-950">Location</h2>
                <p class="mt-1 text-sm text-slate-500">Leave empty to hide it on the site.</p>
            </div>
            <div class="grid gap-5 sm:grid-cols-2">
                <x-auth.input name="location[city]" label="City" :value="$location['city']" />
                <x-auth.input name="location[country]" label="Country" :value="$location['country']" />
            </div>
            <x-auth.input name="location[address]" label="Office address" :value="$location['address']" hint="Optional. Shown on About and Contact." />
            <x-auth.input name="location[note]" label="Note" :value="$location['note']" placeholder="e.g. Office in Dubai, team works remotely across Europe" hint="Optional one line under the location." />
        </section>

        <section class="grid content-start gap-4 rounded-xl border border-ocean-100 bg-white p-6">
            <div>
                <h2 class="font-display font-semibold text-ocean-950">Team</h2>
                <p class="mt-1 text-sm text-slate-500">Number of people per department. Leave empty to show the department without a number.</p>
            </div>
            @foreach ($departments as $key => $d)
                <div class="flex items-center gap-4 border-t border-ocean-50 pt-4">
                    <x-icon :name="$d['icon']" class="size-5 shrink-0 text-ocean-500" />
                    <span class="min-w-0 flex-1 text-sm font-medium text-ocean-950">{{ $d['title'] }}</span>
                    <input type="number" min="0" name="team[{{ $key }}][size]" value="{{ old("team.$key.size", $d['size']) }}" class="field !w-24" placeholder="—" aria-label="{{ $d['title'] }} head count">
                    <label class="flex items-center gap-2 text-sm text-slate-600">
                        <input type="hidden" name="team[{{ $key }}][visible]" value="0">
                        <input type="checkbox" name="team[{{ $key }}][visible]" value="1" class="size-4 accent-ocean-600" @checked($d['visible'])> Show
                    </label>
                </div>
            @endforeach
            @error('team.*') <span class="text-sm text-rose-600">{{ $message }}</span> @enderror
        </section>

        <div class="lg:col-span-2"><button type="submit" class="btn btn-primary">Save</button></div>
    </form>
</x-layouts.admin>
