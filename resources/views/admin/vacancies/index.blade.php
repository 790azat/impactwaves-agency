<x-layouts.admin title="Vacancies">
    <x-slot:header>
        <x-admin.heading title="Vacancies" lead="Open roles shown on the Careers page." />
        <a href="{{ route('admin.vacancies.create') }}" class="btn btn-primary"><x-icon name="plus" class="size-4" /> New vacancy</a>
    </x-slot:header>

    <div class="overflow-hidden rounded-xl border border-ocean-100 bg-white">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="border-b border-ocean-100 bg-slate-50 text-xs tracking-wide text-slate-500 uppercase">
                    <tr><th class="px-5 py-3 font-semibold">Role</th><th class="px-5 py-3 font-semibold">Department</th><th class="px-5 py-3 font-semibold">Location</th><th class="px-5 py-3 font-semibold">State</th><th class="px-5 py-3"></th></tr>
                </thead>
                <tbody class="divide-y divide-ocean-50">
                    @forelse ($vacancies as $vacancy)
                        <tr>
                            <td class="px-5 py-3.5">
                                <a href="{{ route('admin.vacancies.edit', $vacancy) }}" class="font-medium text-ocean-950 hover:text-ocean-600">{{ $vacancy->title }}</a>
                                <p class="text-slate-500">{{ $vacancy->employment_type }}@if ($vacancy->salary) · {{ $vacancy->salary }}@endif</p>
                            </td>
                            <td class="px-5 py-3.5 whitespace-nowrap text-slate-600">{{ $vacancy->departmentTitle() }}</td>
                            <td class="px-5 py-3.5 whitespace-nowrap text-slate-600">{{ $vacancy->location ?: '—' }}</td>
                            <td class="px-5 py-3.5 whitespace-nowrap">
                                @if ($vacancy->published)
                                    <span class="rounded-md bg-emerald-100 px-2 py-0.5 text-xs font-semibold text-emerald-800">Open</span>
                                @else
                                    <span class="rounded-md bg-slate-100 px-2 py-0.5 text-xs font-semibold text-slate-600">Hidden</span>
                                @endif
                            </td>
                            <td class="px-5 py-3.5">
                                <div class="flex justify-end gap-3 whitespace-nowrap">
                                    @if ($vacancy->published)
                                        <a href="{{ route('careers.show', $vacancy->slug) }}" target="_blank" class="text-slate-400 hover:text-ocean-600" aria-label="View on site"><x-icon name="eye" class="size-4" /></a>
                                    @endif
                                    <a href="{{ route('admin.vacancies.edit', $vacancy) }}" class="text-slate-400 hover:text-ocean-600" aria-label="Edit"><x-icon name="pencil" class="size-4" /></a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-5 py-12 text-center text-slate-500">No vacancies yet. While the list is empty, the Careers page invites people to send an open application.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-layouts.admin>
