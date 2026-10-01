<x-auth.card title="Choose a new password">
    <form method="POST" action="{{ route('password.update') }}" class="grid gap-5">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">
        <x-auth.input name="email" type="email" label="Email" :value="$email" autocomplete="email" required />
        <x-auth.input name="password" type="password" label="New password" autocomplete="new-password" hint="At least 8 characters." required autofocus />
        <x-auth.input name="password_confirmation" type="password" label="Confirm password" autocomplete="new-password" required />
        <button type="submit" class="btn btn-primary w-full"><x-icon name="lock" class="size-4" /> Save password</button>
    </form>
</x-auth.card>
