<x-layouts.admin :title="'Chat with '.$conversation->name">
    <x-slot:header>
        <div>
            <a href="{{ route('admin.chats.index') }}" class="inline-flex items-center gap-1.5 text-sm text-slate-500 hover:text-ocean-950"><x-icon name="arrow-left" class="size-4" /> Chats</a>
            <h1 class="mt-2 font-display text-3xl font-semibold tracking-tight text-ocean-950">{{ $conversation->name }}</h1>
            <p class="mt-1.5 text-sm text-slate-600">
                @if ($conversation->email)<a href="mailto:{{ $conversation->email }}" class="hover:text-ocean-600">{{ $conversation->email }}</a> · @endif
                {{ $conversation->user ? 'Registered user' : 'Guest' }} · started {{ $conversation->created_at->format('M j, Y H:i') }} UTC
            </p>
        </div>
        <form method="POST" action="{{ route('admin.chats.destroy', $conversation) }}" onsubmit="return confirm('Delete this conversation?')">
            @csrf @method('DELETE')
            <button type="submit" class="inline-flex items-center gap-2 text-sm font-medium text-rose-600 hover:text-rose-800"><x-icon name="trash" class="size-4" /> Delete</button>
        </form>
    </x-slot:header>

    <div class="mx-auto max-w-3xl">
        @if ($conversation->page_url)
            <p class="mb-4 text-xs text-slate-500">Started on <a href="{{ $conversation->page_url }}" target="_blank" rel="noopener" class="text-ocean-600 hover:text-ocean-800">{{ $conversation->page_url }}</a></p>
        @endif
        <div class="space-y-3 rounded-xl border border-ocean-100 bg-white p-5">
            @foreach ($conversation->messages as $message)
                <div @class(['flex', 'justify-end' => $message->sender === 'agent'])>
                    <div @class([
                        'max-w-[80%] rounded-lg px-4 py-2.5 text-sm leading-relaxed whitespace-pre-line',
                        'rounded-tr-sm bg-ocean-600 text-white' => $message->sender === 'agent',
                        'rounded-tl-sm bg-slate-100 text-slate-800' => $message->sender !== 'agent',
                    ])>{{ $message->body }}<span @class(['mt-1 block text-[11px]', 'text-ocean-100' => $message->sender === 'agent', 'text-slate-500' => $message->sender !== 'agent'])>{{ $message->created_at->format('M j, H:i') }}</span></div>
                </div>
            @endforeach
        </div>

        <form method="POST" action="{{ route('admin.chats.reply', $conversation) }}" class="mt-4 flex items-end gap-3">
            @csrf
            <textarea name="body" rows="2" required maxlength="4000" placeholder="Write a reply…" class="field flex-1 resize-y !rounded-lg text-sm"></textarea>
            <button type="submit" class="btn btn-primary"><x-icon name="send" class="size-4" /> Send</button>
        </form>
        @error('body') <p class="mt-2 text-sm text-rose-600">{{ $message }}</p> @enderror
    </div>
</x-layouts.admin>
