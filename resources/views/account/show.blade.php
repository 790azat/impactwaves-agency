<x-layouts.app title="My account" :noindex="true">
    <section class="bg-sea relative isolate overflow-hidden border-b border-ocean-100 pt-36 pb-14 sm:pt-44">
        @include('partials.caustics', ['tint' => true, 'fade' => 'radial-gradient(ellipse 70% 80% at 80% 10%, #000 15%, transparent 70%)'])
        <div class="mx-auto flex max-w-5xl flex-wrap items-end justify-between gap-6 px-4 sm:px-6">
            <div>
                <p class="eyebrow">My account</p>
                <h1 class="mt-5 font-display text-4xl font-semibold tracking-tight text-ocean-950 sm:text-5xl">Hello, {{ $user->name }}</h1>
                <p class="mt-3 text-slate-600">Member since {{ $user->created_at->format('F Y') }}</p>
            </div>
            <div class="flex flex-wrap gap-3">
                @if ($user->is_admin)
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-ghost"><x-icon name="shield" class="size-4" /> Admin panel</a>
                @endif
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-ghost"><x-icon name="logout" class="size-4" /> Sign out</button>
                </form>
            </div>
        </div>
    </section>

    <div class="mx-auto grid max-w-5xl gap-8 px-4 py-14 sm:px-6 lg:grid-cols-5">
        @if (session('status'))
            <p class="rounded-lg border border-ocean-200 bg-ocean-50 px-4 py-3 text-sm text-ocean-900 lg:col-span-5">{{ session('status') }}</p>
        @endif

        <section class="lg:col-span-3">
            <div class="flex items-center justify-between gap-4">
                <h2 class="font-display text-2xl font-semibold text-ocean-950">My requests</h2>
                <a href="{{ route('contact') }}" class="btn btn-primary !px-4 !py-2.5"><x-icon name="plus" class="size-4" /> New request</a>
            </div>
            <div class="mt-6 grid gap-4">
                @forelse ($leads as $lead)
                    <article class="rounded-xl border border-ocean-100 bg-white p-5">
                        <div class="flex flex-wrap items-center justify-between gap-3">
                            <p class="text-sm text-slate-500">{{ $lead->created_at->format('M j, Y') }}</p>
                            <x-admin.status :status="$lead->status" />
                        </div>
                        <p class="mt-3 font-medium text-ocean-950">{{ implode(', ', $lead->serviceTitles()) }}</p>
                        <p class="mt-2 line-clamp-3 text-sm leading-relaxed text-slate-600">{{ $lead->message }}</p>
                    </article>
                @empty
                    <div class="rounded-xl border border-dashed border-ocean-200 bg-white p-8 text-center">
                        <x-icon name="inbox" class="mx-auto size-8 text-ocean-400" />
                        <p class="mt-3 text-slate-600">No requests yet. Tell us about your project and it will show up here.</p>
                    </div>
                @endforelse
            </div>
        </section>

        <aside class="grid content-start gap-8 lg:col-span-2">
            <form method="POST" action="{{ route('account.update') }}" class="grid gap-5 rounded-xl border border-ocean-100 bg-white p-6">
                @csrf @method('PUT')
                <h2 class="font-display text-lg font-semibold text-ocean-950">Profile</h2>
                <x-auth.input name="name" label="Name" :value="$user->name" bag="profile" required />
                <x-auth.input name="email" type="email" label="Email" :value="$user->email" bag="profile" required />
                <x-auth.input name="company" label="Company" :value="$user->company" bag="profile" />
                <button type="submit" class="btn btn-primary">Save profile</button>
            </form>

            <form method="POST" action="{{ route('account.password') }}" class="grid gap-5 rounded-xl border border-ocean-100 bg-white p-6">
                @csrf @method('PUT')
                <h2 class="font-display text-lg font-semibold text-ocean-950">Password</h2>
                <x-auth.input name="current_password" type="password" label="Current password" bag="password" autocomplete="current-password" required />
                <x-auth.input name="password" type="password" label="New password" bag="password" autocomplete="new-password" required />
                <x-auth.input name="password_confirmation" type="password" label="Confirm new password" bag="password" autocomplete="new-password" required />
                <button type="submit" class="btn btn-ghost">Change password</button>
            </form>
        </aside>
    </div>
</x-layouts.app>
