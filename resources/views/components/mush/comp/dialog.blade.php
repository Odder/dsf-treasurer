@props([
    'id' => 'my-dialog',
    'title' => null,
    'open' => false,
    'maxWidth' => 'md',
])

@php
    $maxWidthClasses = [
        'sm' => 'sm:max-w-sm',
        'md' => 'sm:max-w-md',
        'lg' => 'sm:max-w-lg',
        'xl' => 'sm:max-w-xl',
        '2xl' => 'sm:max-w-2xl',
    ];

    $maxWidthClass = $maxWidthClasses[$maxWidth] ?? '';
@endphp

<dialog
    id="{{ $id }}"
    class="bg-white dark:bg-gray-800 rounded-lg shadow-xl {{ $maxWidthClass }} w-1/2"
    x-data="{ open: {{ $open ? 'true' : 'false' }} }"
    x-on:open-dialog.window="if ($event.detail.id === '{{ $id }}') { open = true; $el.showModal(); }"
    x-on:close-dialog.window="open = false; $el.close();"
    x-effect="open ? $el.showModal() : $el.close()"
>
    <div class="p-6">
        @if($title)
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
                {{ $title }}
            </h2>
        @endif

        <div class="mb-4">
            {{ $slot }}
        </div>
    </div>
</dialog>
