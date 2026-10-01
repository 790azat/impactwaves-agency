<x-auth.card title="Reset your password" lead="Enter the email you signed up with and we will send you a link to choose a new password.">
    <form method="POST" action="{{ route('password.email') }}" class="grid gap-5">
        @csrf
        <x-auth.input name="email" type="email" label="Email" autocomplete="email" required autofocus />
        <button type="submit" class="btn btn-primary w-full"><x-icon name="mail" class="size-4" /> Send reset link</button>
    </form>
    <x-slot:footer><a href="{{ route('login') }}" class="font-semibold text-ocean-600 hover:text-ocean-800">Back to sign in</a></x-slot:footer>
</x-auth.card>
