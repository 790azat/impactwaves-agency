<x-layouts.admin title="Dashboard">
    <x-slot:header>
        <x-admin.heading title="Dashboard" :lead="'Welcome back, '.auth()->user()->name.'.'" />
    </x-slot:header>

    <div class="grid grid-cols-2 gap-4 lg:grid-cols-4">
        @foreach ($stats as $stat)
            <a href="{{ $stat['href'] }}" class="rounded-xl border border-ocean-100 bg-white p-5 transition hover:border-ocean-300">
                <p class="text-sm text-slate-500">{{ $stat['label'] }}</p>
                <p class="mt-2 font-display text-3xl font-semibold text-ocean-950">{{ number_format($stat['value']) }}</p>
            </a>
        @endforeach
    </div>

    <div class="mt-8 grid gap-6 lg:grid-cols-5">
        <section class="rounded-xl border border-ocean-100 bg-white lg:col-span-3">
            <div class="flex items-center justify-between border-b border-ocean-100 px-5 py-4">
                <h2 class="font-display font-semibold text-ocean-950">Latest leads</h2>
                <a href="{{ route('admin.leads.index') }}" class="text-sm font-medium text-ocean-600 hover:text-ocean-800">All leads</a>
            </div>
            <ul class="divide-y divide-ocean-50">
                @forelse ($leads as $lead)
                    <li>
                        <a href="{{ route('admin.leads.show', $lead) }}" class="flex items-center justify-between gap-4 px-5 py-3.5 hover:bg-slate-50">
                            <span class="min-w-0">
                                <span class="block truncate font-medium text-ocean-950">{{ $lead->name }}@if ($lead->company) <span class="font-normal text-slate-500">· {{ $lead->company }}</span>@endif</span>
                                <span class="block truncate text-sm text-slate-500">{{ $lead->budgetLabel() }} · {{ $lead->created_at->diffForHumans() }}</span>
                            </span>
                            <x-admin.status :status="$lead->status" />
                        </a>
                    </li>
                @empty
                    <li class="px-5 py-10 text-center text-sm text-slate-500">No leads yet. Contact form submissions will appear here.</li>
                @endforelse
            </ul>
        </section>

        <section class="rounded-xl border border-ocean-100 bg-white lg:col-span-2">
            <div class="flex items-center justify-between border-b border-ocean-100 px-5 py-4">
                <h2 class="font-display font-semibold text-ocean-950">New users</h2>
                <a href="{{ route('admin.users.index') }}" class="text-sm font-medium text-ocean-600 hover:text-ocean-800">All users</a>
            </div>
            <ul class="divide-y divide-ocean-50">
                @foreach ($users as $user)
                    <li class="flex items-center justify-between gap-4 px-5 py-3.5">
                        <span class="min-w-0">
                            <span class="block truncate font-medium text-ocean-950">{{ $user->name }}</span>
                            <span class="block truncate text-sm text-slate-500">{{ $user->email }}</span>
                        </span>
                        <span class="shrink-0 text-xs text-slate-500">{{ $user->created_at->diffForHumans(short: true) }}</span>
                    </li>
                @endforeach
            </ul>
        </section>
    </div>

    <div class="mt-6 flex flex-wrap gap-3">
        <a href="{{ route('admin.articles.create') }}" class="btn btn-primary"><x-icon name="plus" class="size-4" /> New article</a>
        <a href="{{ route('admin.articles.create', ['section' => 'news']) }}" class="btn btn-ghost"><x-icon name="newspaper" class="size-4" /> Post news</a>
    </div>
</x-layouts.admin>
