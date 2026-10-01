{{-- Checks for replies every 4s while open, every 32s while closed, only once a chat exists. --}}
<div x-data x-init="let n = 0; setInterval(() => { n++; if (! $wire.conversationId || document.hidden) return; if ($wire.open || n % 8 === 0) $wire.$refresh() }, 4000)">
    @if ($available)
        <div class="fixed right-4 bottom-4 z-[60] flex flex-col items-end gap-3 sm:right-6 sm:bottom-6">
            @if ($open)
                <section class="flex h-[min(520px,calc(100dvh-7rem))] w-[calc(100vw-2rem)] flex-col overflow-hidden rounded-xl border border-ocean-100 bg-white shadow-2xl shadow-ocean-950/20 sm:w-96"
                         role="dialog" aria-label="Chat with Impact Waves">
                    <header class="flex items-center justify-between gap-3 bg-ocean-950 px-5 py-4 text-white">
                        <div class="flex items-center gap-3">
                            <span class="grid size-9 place-items-center rounded-lg bg-white/10"><x-logo-mark class="h-4 w-auto text-[#4AA3F0]" /></span>
                            <div>
                                <p class="font-display text-sm font-semibold">Impact Waves team</p>
                                <p class="flex items-center gap-1.5 text-xs text-ocean-200"><span class="size-1.5 rounded-full bg-emerald-400"></span> We usually reply within an hour</p>
                            </div>
                        </div>
                        <button type="button" wire:click="toggle" class="grid size-8 place-items-center rounded-md text-ocean-200 hover:bg-white/10 hover:text-white" aria-label="Close chat"><x-icon name="close" class="size-5" /></button>
                    </header>

                    <div class="flex-1 space-y-3 overflow-y-auto bg-slate-50 px-4 py-5" x-data x-init="$el.scrollTop = $el.scrollHeight; new MutationObserver(() => $el.scrollTop = $el.scrollHeight).observe($el, { childList: true, subtree: true })">
                        <div class="max-w-[85%] rounded-lg rounded-tl-sm border border-ocean-100 bg-white px-3.5 py-2.5 text-sm leading-relaxed text-slate-700">
                            Hi! Ask us anything about paid traffic, TikTok agency accounts or search feeds. A media buyer will answer right here.
                        </div>
                        @foreach ($messages as $message)
                            <div wire:key="m-{{ $message->id }}" @class(['flex', 'justify-end' => $message->sender === 'visitor'])>
                                <div @class([
                                    'max-w-[85%] rounded-lg px-3.5 py-2.5 text-sm leading-relaxed whitespace-pre-line',
                                    'rounded-tr-sm bg-ocean-600 text-white' => $message->sender === 'visitor',
                                    'rounded-tl-sm border border-ocean-100 bg-white text-slate-700' => $message->sender !== 'visitor',
                                ])>{{ $message->body }}<span @class(['mt-1 block text-[11px]', 'text-ocean-100' => $message->sender === 'visitor', 'text-slate-400' => $message->sender !== 'visitor'])>{{ $message->created_at->format('H:i') }}</span></div>
                            </div>
                        @endforeach
                    </div>

                    <form wire:submit="send" class="grid gap-2 border-t border-ocean-100 bg-white p-3">
                        @unless ($conversationId)
                            <div class="grid grid-cols-2 gap-2">
                                <input type="text" wire:model="name" placeholder="Your name *" autocomplete="name" class="field !rounded-lg !px-3 !py-2 text-sm">
                                <input type="email" wire:model="email" placeholder="Email (optional)" autocomplete="email" class="field !rounded-lg !px-3 !py-2 text-sm">
                            </div>
                            @error('name') <p class="text-xs text-rose-600">{{ $message }}</p> @enderror
                            @error('email') <p class="text-xs text-rose-600">{{ $message }}</p> @enderror
                        @endunless
                        <div class="flex items-end gap-2">
                            <textarea wire:model="body" rows="1" placeholder="Write a message…" maxlength="2000"
                                      x-data x-on:keydown.enter="if (!$event.shiftKey) { $event.preventDefault(); $wire.send() }"
                                      class="field max-h-32 min-h-[42px] flex-1 resize-none !rounded-lg !px-3 !py-2.5 text-sm"></textarea>
                            <button type="submit" class="grid size-[42px] shrink-0 place-items-center rounded-lg bg-ocean-600 text-white hover:bg-ocean-700 disabled:opacity-50" wire:loading.attr="disabled" wire:target="send" aria-label="Send">
                                <x-icon name="send" class="size-5" />
                            </button>
                        </div>
                        @error('body') <p class="text-xs text-rose-600">{{ $message }}</p> @enderror
                    </form>
                </section>
            @endif

            <button type="button" wire:click="toggle"
                    class="relative inline-flex items-center gap-2 rounded-lg bg-ocean-600 px-4 py-3 text-sm font-semibold text-white shadow-lg shadow-ocean-950/25 transition hover:bg-ocean-700"
                    aria-label="{{ $open ? 'Close chat' : 'Chat with us' }}">
                <x-icon :name="$open ? 'close' : 'chat'" class="size-5" />
                <span @class(['hidden sm:inline' => ! $open, 'sr-only' => $open])>{{ $open ? 'Close' : 'Chat with us' }}</span>
                @if ($unread && ! $open)
                    <span class="absolute -top-1.5 -right-1.5 grid size-5 place-items-center rounded-full bg-rose-500 text-[11px] font-bold">{{ $unread }}</span>
                @endif
            </button>
        </div>
    @endif
</div>
