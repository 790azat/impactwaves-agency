<x-layouts.admin title="Chats">
    <x-slot:header>
        <x-admin.heading title="Chats" lead="Conversations from the chat on the site. Answer here or reply in Telegram." />
    </x-slot:header>

    @if (! $telegram['token'] || ! $telegram['chat'])
        <section class="mb-6 rounded-xl border border-ocean-200 bg-white p-6">
            <h2 class="font-display text-lg font-semibold text-ocean-950">Connect the Telegram bot</h2>
            <p class="mt-1 text-sm text-slate-600">The chat button appears on the site once the bot is connected, so every message reaches you.</p>
            <ol class="mt-5 grid gap-4 text-sm">
                <li class="flex gap-3">
                    <span @class(['grid size-6 shrink-0 place-items-center rounded-full text-xs font-semibold', 'bg-emerald-100 text-emerald-800' => $telegram['token'], 'bg-ocean-600 text-white' => ! $telegram['token']])>@if ($telegram['token'])<x-icon name="check" class="size-3.5" />@else 1 @endif</span>
                    <span class="text-slate-700">Create a bot with <a href="https://t.me/BotFather" target="_blank" rel="noopener" class="font-medium text-ocean-600 hover:text-ocean-800">@BotFather</a> and add its token to Vercel as <code class="rounded bg-slate-100 px-1.5 py-0.5 text-xs">TELEGRAM_BOT_TOKEN</code>, then redeploy.</span>
                </li>
                <li class="flex gap-3">
                    <span @class(['grid size-6 shrink-0 place-items-center rounded-full text-xs font-semibold', 'bg-emerald-100 text-emerald-800' => $telegram['bot'], 'bg-ocean-600 text-white' => ! $telegram['bot']])>@if ($telegram['bot'])<x-icon name="check" class="size-3.5" />@else 2 @endif</span>
                    <div class="grid gap-3">
                        <span class="text-slate-700">Connect the bot to the site{{ $telegram['bot'] ? ': @'.$telegram['bot'].' is connected.' : '.' }}</span>
                        @if ($telegram['token'])
                            <form method="POST" action="{{ route('admin.chats.connect') }}">@csrf <button type="submit" class="btn btn-ghost !px-4 !py-2"><x-icon name="refresh" class="size-4" /> {{ $telegram['bot'] ? 'Reconnect' : 'Connect bot' }}</button></form>
                        @endif
                    </div>
                </li>
                <li class="flex gap-3">
                    <span class="grid size-6 shrink-0 place-items-center rounded-full bg-ocean-600 text-xs font-semibold text-white">3</span>
                    <div class="grid gap-3">
                        <span class="text-slate-700">Open the bot from your Telegram and press Start. Chats and leads will arrive in that chat.</span>
                        @if ($telegram['link'])
                            <a href="{{ $telegram['link'] }}" target="_blank" rel="noopener" class="btn btn-primary w-fit !px-4 !py-2"><x-icon name="send" class="size-4" /> Open {{ '@'.$telegram['bot'] }}</a>
                        @endif
                    </div>
                </li>
            </ol>
        </section>
    @else
        <div class="mb-5 flex flex-wrap items-center justify-between gap-3 rounded-lg border border-ocean-100 bg-white px-4 py-3 text-sm text-slate-600">
            <span class="flex items-center gap-2"><span class="size-2 rounded-full bg-emerald-500"></span> Telegram connected{{ $telegram['bot'] ? ' via @'.$telegram['bot'] : '' }}. Reply to a visitor's message in Telegram to answer them.</span>
            @if ($telegram['link'])<a href="{{ $telegram['link'] }}" target="_blank" rel="noopener" class="font-medium text-ocean-600 hover:text-ocean-800">Change chat</a>@endif
        </div>
    @endif

    <div class="overflow-hidden rounded-xl border border-ocean-100 bg-white">
        <ul class="divide-y divide-ocean-50">
            @forelse ($conversations as $conversation)
                <li>
                    <a href="{{ route('admin.chats.show', $conversation) }}" class="flex items-center gap-4 px-5 py-4 hover:bg-slate-50">
                        <span class="grid size-10 shrink-0 place-items-center rounded-full bg-ocean-50 font-display font-semibold text-ocean-700">{{ mb_strtoupper(mb_substr($conversation->name, 0, 1)) }}</span>
                        <span class="min-w-0 flex-1">
                            <span class="flex items-center gap-2">
                                <span @class(['truncate text-ocean-950', 'font-semibold' => $conversation->isUnread(), 'font-medium' => ! $conversation->isUnread()])>{{ $conversation->name }}</span>
                                @if ($conversation->email)<span class="truncate text-sm text-slate-500">{{ $conversation->email }}</span>@endif
                            </span>
                            <span class="block truncate text-sm text-slate-500">@if ($conversation->latestMessage?->sender === 'agent')You: @endif{{ $conversation->latestMessage?->body }}</span>
                        </span>
                        <span class="shrink-0 text-right text-xs text-slate-500">
                            {{ $conversation->last_message_at?->diffForHumans(short: true) }}
                            @if ($conversation->isUnread())<span class="mt-1 ml-auto block size-2 rounded-full bg-ocean-600"></span>@endif
                        </span>
                    </a>
                </li>
            @empty
                <li class="px-5 py-12 text-center text-sm text-slate-500">No conversations yet.</li>
            @endforelse
        </ul>
    </div>

    <div class="mt-6">{{ $conversations->links('admin.pagination') }}</div>
</x-layouts.admin>
