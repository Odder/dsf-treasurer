@props([
    'id',
    'items' => [],
    'label',
    'default' => null,
])

<div>
    <label for="{{ $id }}" class="block">{{ $label }}</label>
    <select
        wire:model.live="{{ $id }}"
        id="{{ $id }}"
        name="{{ $id }}"
        class="border-2 border-gray-600 rounded-md bg-transparent w-full p-2 focus:outline-none focus:border-gray-400 focus:ring-0"
    >
        @if($default)
            <option
                class="dark:bg-gray-800 dark:text-gray-400"
                value=""
            >
                {{ $default }}
            </option>
        @endif
        @foreach($items as $value => $label)
            <option
                class="dark:bg-gray-800"
                value="{{ $value }}"
            >
                {{ $label }}
            </option>
        @endforeach
    </select>
</div>
