@props([
    'level' => 'info',
    'text',
])

@php
    $color = match ($level) {
        'info' => 'blue',
        'warning' => 'yellow',
        'danger' => 'red',
        'success' => 'green',
        default => 'gray',
    };
@endphp

<div class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-{{ $color }}-200 text-{{ $color }}-900">
    {{ $text }}
</div>
