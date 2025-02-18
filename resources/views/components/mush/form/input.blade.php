@props([
    'id',
    'value' => '',
    'placeholder' => '...',
    'label',
])

<div>
    <label for="{{ $id }}" class="block">{{ $label }}</label>
    <input
        wire:model.live="{{ $id }}"
        id="{{ $id }}"
        name="{{ $id }}"
        value="{{ $value }}"
        placeholder="{{ $placeholder }}"
        class="border-2 border-gray-600 rounded-md bg-transparent w-full p-2 focus:outline-none focus:border-gray-400 focus:ring-0"
    />
</div>
