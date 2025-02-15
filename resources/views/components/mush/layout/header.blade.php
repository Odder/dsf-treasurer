@props([
    'header'
])

<header class="bg-white dark:bg-blue-800 shadow dark:text-gray-300 no-print">
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-300 leading-tight">
            @if( $header )
                {{ $header }}
            @else
                Page
            @endif
        </h2>
    </div>
</header>
