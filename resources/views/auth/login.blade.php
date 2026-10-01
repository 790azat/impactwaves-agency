<x-auth.card title="Sign in" lead="Access your Impact Waves account.">
    <form method="POST" action="{{ route('login') }}" class="grid gap-5">
        @csrf
        <x-auth.input name="email" type="email" label="Email" autocomplete="email" required autofocus />
        <x-auth.input name="password" type="password" label="Password" autocomplete="current-password" required>
            <x-slot:aside><a href="{{ route('password.request') }}" class="font-normal text-ocean-600 hover:text-ocean-800">Forgot password?</a></x-slot:aside>
        </x-auth.input>
        <label class="flex items-center gap-2.5 text-sm text-slate-700">
            <input type="checkbox" name="remember" value="1" class="size-4 rounded border-ocean-200 accent-ocean-600" checked> Keep me signed in
        </label>
        <button type="submit" class="btn btn-primary w-full"><x-icon name="lock" class="size-4" /> Sign in</button>
    </form>
    <x-slot:footer>New here? <a href="{{ route('register') }}" class="font-semibold text-ocean-600 hover:text-ocean-800">Create an account</a></x-slot:footer>
</x-auth.card>
