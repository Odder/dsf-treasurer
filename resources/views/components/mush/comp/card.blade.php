@props([
    'title',
])

<div class="overflow-x-auto rounded-lg shadow-md dark:bg-gray-800 dark:text-gray-200">
    @if(isset($title))
        <div class="p-4">
            <h3 class="text-lg font-semibold">{{ $title }}</h3>
        </div>
    @endif
    {{ $slot }}
</div>
