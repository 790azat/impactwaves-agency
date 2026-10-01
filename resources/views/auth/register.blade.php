<x-auth.card title="Create an account" lead="Track your requests to the team and get a faster start on your project.">
    <form method="POST" action="{{ route('register') }}" class="grid gap-5">
        @csrf
        <x-auth.input name="name" label="Name" autocomplete="name" required autofocus />
        <x-auth.input name="email" type="email" label="Work email" autocomplete="email" required />
        <x-auth.input name="company" label="Company" autocomplete="organization" placeholder="Optional" />
        <x-auth.input name="password" type="password" label="Password" autocomplete="new-password" hint="At least 8 characters." required />
        <x-auth.input name="password_confirmation" type="password" label="Confirm password" autocomplete="new-password" required />
        <div class="hidden" aria-hidden="true"><label>Nickname <input type="text" name="nickname" tabindex="-1" autocomplete="off"></label></div>
        <button type="submit" class="btn btn-primary w-full"><x-icon name="user" class="size-4" /> Create account</button>
    </form>
    <x-slot:footer>Already have an account? <a href="{{ route('login') }}" class="font-semibold text-ocean-600 hover:text-ocean-800">Sign in</a></x-slot:footer>
</x-auth.card>
