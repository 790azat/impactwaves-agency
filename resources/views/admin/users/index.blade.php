<x-layouts.admin title="Users">
    <x-slot:header>
        <x-admin.heading title="Users" :lead="$users->total().' registered '.str('account')->plural($users->total())" />
        <x-admin.search :value="$search" placeholder="Name, email or company" />
    </x-slot:header>

    <div class="overflow-hidden rounded-xl border border-ocean-100 bg-white">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="border-b border-ocean-100 bg-slate-50 text-xs tracking-wide text-slate-500 uppercase">
                    <tr><th class="px-5 py-3 font-semibold">User</th><th class="px-5 py-3 font-semibold">Company</th><th class="px-5 py-3 font-semibold">Leads</th><th class="px-5 py-3 font-semibold">Joined</th><th class="px-5 py-3 font-semibold">Last sign-in</th><th class="px-5 py-3 font-semibold">Role</th><th class="px-5 py-3"></th></tr>
                </thead>
                <tbody class="divide-y divide-ocean-50">
                    @forelse ($users as $user)
                        <tr>
                            <td class="px-5 py-3.5"><p class="font-medium text-ocean-950">{{ $user->name }}</p><p class="text-slate-500">{{ $user->email }}</p></td>
                            <td class="px-5 py-3.5 text-slate-600">{{ $user->company ?: '—' }}</td>
                            <td class="px-5 py-3.5 text-slate-600">
                                @if ($user->leads_count)<a href="{{ route('admin.leads.index', ['q' => $user->email]) }}" class="text-ocean-600 hover:text-ocean-800">{{ $user->leads_count }}</a>@else 0 @endif
                            </td>
                            <td class="px-5 py-3.5 whitespace-nowrap text-slate-600">{{ $user->created_at->format('M j, Y') }}</td>
                            <td class="px-5 py-3.5 whitespace-nowrap text-slate-600">{{ $user->last_login_at?->diffForHumans() ?? '—' }}</td>
                            <td class="px-5 py-3.5">
                                @if ($user->is_admin)
                                    <span class="inline-flex items-center gap-1 rounded-md bg-ocean-950 px-2 py-0.5 text-xs font-semibold text-white"><x-icon name="shield" class="size-3.5" /> Admin</span>
                                @else
                                    <span class="rounded-md bg-slate-100 px-2 py-0.5 text-xs font-semibold text-slate-600">Member</span>
                                @endif
                            </td>
                            <td class="px-5 py-3.5">
                                @unless ($user->is(auth()->user()))
                                    <div class="flex justify-end gap-3 whitespace-nowrap">
                                        <form method="POST" action="{{ route('admin.users.update', $user) }}" onsubmit="return confirm({{ \Illuminate\Support\Js::from($user->is_admin ? "Remove admin rights from {$user->name}?" : "Make {$user->name} an admin?") }})">
                                            @csrf @method('PUT')
                                            <input type="hidden" name="is_admin" value="{{ $user->is_admin ? 0 : 1 }}">
                                            <button type="submit" class="text-sm font-medium text-ocean-600 hover:text-ocean-800">{{ $user->is_admin ? 'Revoke admin' : 'Make admin' }}</button>
                                        </form>
                                        <form method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm({{ \Illuminate\Support\Js::from("Delete {$user->name}? Their leads stay in the list.") }})">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-slate-400 hover:text-rose-600" aria-label="Delete user"><x-icon name="trash" class="size-4" /></button>
                                        </form>
                                    </div>
                                @endunless
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="px-5 py-12 text-center text-slate-500">No users found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6">{{ $users->links('admin.pagination') }}</div>
</x-layouts.admin>
