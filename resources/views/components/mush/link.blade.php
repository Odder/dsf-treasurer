@props([
    'link',
])

<a href="{{ $link }}" wire:navigate.hover>
    {{ $slot }}
</a>
