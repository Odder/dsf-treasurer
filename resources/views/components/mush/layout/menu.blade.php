<aside
    class="fixed top-0 hidden md:flex md:w-64 bg-gray-800 text-white  dark:text-gray-300 py-6 px-3 flex-shrink-0 flex flex-col h-screen">
    <!-- Added fixed and top-0 -->
    <nav>
        @if(isset($header))
            <div class="mb-6 p4">
                {{ $header }}
            </div>
        @endif

        {{ $slot }}
    </nav>
</aside>
