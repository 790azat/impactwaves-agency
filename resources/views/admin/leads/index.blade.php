<x-layouts.admin title="Leads">
    <x-slot:header>
        <x-admin.heading title="Leads" lead="Requests sent through the contact form." />
        <x-admin.search :value="$search" placeholder="Name, email or company" />
    </x-slot:header>

    <div class="mb-5 flex flex-wrap gap-2">
        <a href="{{ route('admin.leads.index', array_filter(['q' => $search])) }}" @class(['rounded-md px-3 py-1.5 text-sm font-medium', 'bg-ocean-950 text-white' => ! $status, 'bg-white text-slate-600 border border-ocean-100 hover:border-ocean-300' => $status])>All <span class="opacity-60">{{ $counts->sum() }}</span></a>
        @foreach (\App\Models\Lead::STATUSES as $key => $label)
            <a href="{{ route('admin.leads.index', array_filter(['status' => $key, 'q' => $search])) }}" @class(['rounded-md px-3 py-1.5 text-sm font-medium', 'bg-ocean-950 text-white' => $status === $key, 'bg-white text-slate-600 border border-ocean-100 hover:border-ocean-300' => $status !== $key])>{{ $label }} <span class="opacity-60">{{ $counts[$key] ?? 0 }}</span></a>
        @endforeach
    </div>

    <div class="overflow-hidden rounded-xl border border-ocean-100 bg-white">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="border-b border-ocean-100 bg-slate-50 text-xs tracking-wide text-slate-500 uppercase">
                    <tr><th class="px-5 py-3 font-semibold">Contact</th><th class="px-5 py-3 font-semibold">Services</th><th class="px-5 py-3 font-semibold">Budget</th><th class="px-5 py-3 font-semibold">Received</th><th class="px-5 py-3 font-semibold">Status</th></tr>
                </thead>
                <tbody class="divide-y divide-ocean-50">
                    @forelse ($leads as $lead)
                        <tr class="cursor-pointer hover:bg-slate-50" onclick="location.href='{{ route('admin.leads.show', $lead) }}'">
                            <td class="px-5 py-3.5">
                                <a href="{{ route('admin.leads.show', $lead) }}" class="font-medium text-ocean-950">{{ $lead->name }}</a>
                                <p class="text-slate-500">{{ $lead->email }}@if ($lead->company) · {{ $lead->company }}@endif</p>
                            </td>
                            <td class="max-w-56 px-5 py-3.5 text-slate-600">{{ implode(', ', $lead->serviceTitles()) }}</td>
                            <td class="px-5 py-3.5 whitespace-nowrap text-slate-600">{{ $lead->budgetLabel() }}</td>
                            <td class="px-5 py-3.5 whitespace-nowrap text-slate-600" title="{{ $lead->created_at }}">{{ $lead->created_at->format('M j, Y') }}</td>
                            <td class="px-5 py-3.5"><x-admin.status :status="$lead->status" /></td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-5 py-12 text-center text-slate-500">No leads found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6">{{ $leads->links('admin.pagination') }}</div>
</x-layouts.admin>
