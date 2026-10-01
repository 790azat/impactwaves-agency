<div class="glass relative overflow-hidden rounded-2xl p-6 shadow-2xl shadow-ocean-900/10 sm:p-10">
    <div class="absolute -top-24 -right-24 size-64 rounded-full bg-ocean-500/20 blur-3xl"></div>

    @if ($sent)
        <div class="relative py-16 text-center" x-data x-init="$el.scrollIntoView({ behavior: 'smooth', block: 'center' })">
            <div class="mx-auto grid size-20 place-items-center rounded-full bg-brand shadow-lg">
                <x-icon name="check" class="size-10 text-white" />
            </div>
            <h2 class="mt-8 font-display text-3xl font-semibold text-ocean-950">Thanks, message received</h2>
            <p class="mx-auto mt-3 max-w-md text-slate-600">We will review your details and get back to you shortly with next steps.</p>
            <button type="button" wire:click="$set('sent', false)" class="btn btn-ghost mt-8"><x-icon name="refresh" class="size-4" /> Send another message</button>
        </div>
    @else
        <form wire:submit="submit" class="relative grid gap-6" novalidate>
            <div>
                <h2 class="font-display text-2xl font-semibold text-ocean-950">Tell us about your project</h2>
                <p class="mt-1 text-sm text-slate-600">Fields marked with * are required.</p>
            </div>

            <div class="grid gap-6 sm:grid-cols-2">
                <label class="grid gap-2">
                    <span class="text-sm font-medium text-slate-700">Name *</span>
                    <input type="text" wire:model.blur="name" autocomplete="name" class="field" placeholder="Jane Cooper">
                    @error('name') <span class="text-sm text-rose-600">{{ $message }}</span> @enderror
                </label>
                <label class="grid gap-2">
                    <span class="text-sm font-medium text-slate-700">Work email *</span>
                    <input type="email" wire:model.blur="email" autocomplete="email" class="field" placeholder="jane@company.com">
                    @error('email') <span class="text-sm text-rose-600">{{ $message }}</span> @enderror
                </label>
                <label class="grid gap-2">
                    <span class="text-sm font-medium text-slate-700">Company</span>
                    <input type="text" wire:model.blur="company" autocomplete="organization" class="field" placeholder="Company or website">
                    @error('company') <span class="text-sm text-rose-600">{{ $message }}</span> @enderror
                </label>
                <label class="grid gap-2">
                    <span class="text-sm font-medium text-slate-700">Monthly ad budget *</span>
                    <select wire:model.change="budget" class="field appearance-none bg-[url('data:image/svg+xml;utf8,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 20 20%22 fill=%22%2394a3b8%22><path d=%22M5.3 7.3a1 1 0 0 1 1.4 0L10 10.6l3.3-3.3a1 1 0 1 1 1.4 1.4l-4 4a1 1 0 0 1-1.4 0l-4-4a1 1 0 0 1 0-1.4Z%22/></svg>')] bg-[length:1.25rem] bg-[right_1rem_center] bg-no-repeat pr-10">
                        <option value="">Select a range</option>
                        @foreach ($budgetOptions as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('budget') <span class="text-sm text-rose-600">{{ $message }}</span> @enderror
                </label>
            </div>

            <fieldset class="grid gap-3">
                <legend class="mb-3 text-sm font-medium text-slate-700">What can we help with? *</legend>
                <div class="flex flex-wrap gap-2.5">
                    @foreach ($serviceOptions as $slug => $service)
                        <label wire:key="svc-{{ $slug }}" class="cursor-pointer">
                            <input type="checkbox" value="{{ $slug }}" wire:model.live="services" class="peer sr-only">
                            <span class="inline-flex items-center gap-2 rounded-md border border-ocean-100 px-4 py-2.5 text-sm text-slate-700 transition select-none hover:border-ocean-200 peer-checked:border-transparent peer-checked:bg-brand peer-checked:text-white peer-focus-visible:ring-2 peer-focus-visible:ring-ocean-300">
                                <x-icon :name="$service['icon']" class="size-4" /> {{ $service['title'] }}
                            </span>
                        </label>
                    @endforeach
                </div>
                @error('services') <span class="text-sm text-rose-600">{{ $message }}</span> @enderror
            </fieldset>

            <label class="grid gap-2">
                <span class="flex justify-between text-sm font-medium text-slate-700">
                    <span>Goals and context *</span>
                    <span class="font-normal text-slate-500" x-data x-text="$wire.message.length + ' / 3000'"></span>
                </span>
                <textarea wire:model.blur="message" rows="5" class="field resize-y" placeholder="What are you selling, where do you advertise today and what would success look like?"></textarea>
                @error('message') <span class="text-sm text-rose-600">{{ $message }}</span> @enderror
            </label>

            <div class="hidden" aria-hidden="true">
                <label>Nickname <input type="text" wire:model="nickname" tabindex="-1" autocomplete="off"></label>
            </div>

            @error('form')
                <p class="rounded-xl border border-rose-500/30 bg-rose-500/10 px-4 py-3 text-sm text-rose-700">{{ $message }}</p>
            @enderror

            <div class="flex flex-col-reverse items-start justify-between gap-4 sm:flex-row sm:items-center">
                <p class="text-xs text-slate-500">We only use your details to reply to this request.</p>
                <button type="submit" class="btn btn-primary w-full sm:w-auto" wire:loading.attr="disabled" wire:target="submit">
                    <span wire:loading.remove wire:target="submit" class="inline-flex items-center gap-2"><x-icon name="send" class="size-4" /> Send message</span>
                    <span wire:loading wire:target="submit" class="inline-flex items-center gap-2">
                        <svg class="size-4 animate-spin" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-opacity=".3" stroke-width="3"/><path d="M21 12a9 9 0 0 0-9-9" stroke="currentColor" stroke-width="3" stroke-linecap="round"/></svg>
                        Sending...
                    </span>
                </button>
            </div>
        </form>
    @endif
</div>
