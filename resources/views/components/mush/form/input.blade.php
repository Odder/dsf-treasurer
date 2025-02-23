@props([
    'id',
    'value' => '',
    'placeholder' => '...',
    'label',
    'enter' => false,
    'change' => false,
])

<div>
    <label for="{{ $id }}" class="block dark:text-gray-200">{{ $label }}</label>
    <input
        wire:model="{{ $id }}"
        id="{{ $id }}"
        name="{{ $id }}"
        value="{{ $value }}"
        placeholder="{{ $placeholder }}"
        class="dark:text-gray-200 border-2 border-gray-600 rounded-md bg-transparent w-full p-2 focus:outline-none focus:border-gray-400 focus:ring-0"
        @if($enter)
            wire:keydown.enter="{{ $enter }}"
        @endif
        @if($change)
            wire:keydown="{{ $change }}"
        @endif
    />
</div>
