@props([
    'link',
])

<a href="{{ $link }}" wire:navigate.hover class="hover:underline">
    {{ $slot }}
</a>
