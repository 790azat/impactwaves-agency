{{--
    Layered surface waves that drift at different speeds.
    Expects: $id (unique per page), $fill (colour of the front wave, match the next section),
    optional $class for size/position and $tint (rgb triplet for the back layers).
--}}
@php $tint = $tint ?? '8 150 181'; @endphp
<svg class="sea-waves pointer-events-none block w-full {{ $class ?? 'h-24 sm:h-32' }}" viewBox="0 24 150 28" preserveAspectRatio="none" aria-hidden="true">
    <defs>
        <path id="{{ $id }}" d="M-160 44c30 0 58-18 88-18s58 18 88 18 58-18 88-18 58 18 88 18v44h-352z" />
    </defs>
    <g>
        <use href="#{{ $id }}" x="48" y="0" fill="rgb({{ $tint }} / .32)" />
        <use href="#{{ $id }}" x="48" y="3" fill="rgb({{ $tint }} / .22)" />
        <use href="#{{ $id }}" x="48" y="5" fill="rgb({{ $tint }} / .14)" />
        <use href="#{{ $id }}" x="48" y="7" fill="{{ $fill }}" />
    </g>
</svg>
