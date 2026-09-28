@props(['id' => 'iw'])
{{-- "Wave W" mark: one wavy stroke that forms a W. Source: /mnt/project-files/logo/logo-mark.svg --}}
<svg {{ $attributes->merge(['viewBox' => '4 18 88 64', 'fill' => 'none', 'xmlns' => 'http://www.w3.org/2000/svg', 'aria-hidden' => 'true']) }}>
    <defs>
        <linearGradient id="{{ $id }}-g" x1="10" y1="86" x2="86" y2="10" gradientUnits="userSpaceOnUse">
            <stop stop-color="#22D3EE"/>
            <stop offset=".5" stop-color="#6366F1"/>
            <stop offset="1" stop-color="#E879F9"/>
        </linearGradient>
    </defs>
    <path d="M14 30 C23 30 25 70 33 70 C41 70 42 42 48 42 C54 42 55 70 63 70 C71 70 73 30 82 30" stroke="url(#{{ $id }}-g)" stroke-width="10" stroke-linecap="round"/>
</svg>
