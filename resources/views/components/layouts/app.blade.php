<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#1f2937">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'DSF Kontigent') }}</title>
    @livewireStyles

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Scripts -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="{{ asset('vendor/bladewind/css/animate.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('vendor/bladewind/css/bladewind-ui.min.css') }}" rel="stylesheet" />
    <script src="{{ asset('vendor/bladewind/js/helpers.js') }}"></script>

    <style>
        @media print {
            .no-print {
                display: none !important;
            }

            .invoice-container {
                box-shadow: none !important;
            }
        }
    </style>
</head>
<body class="font-sans antialiased dark:bg-dark700">
<div class="min-h-screen bg-gray-100 dark:bg-dark700" style="background-color: #1f2937;">
    <div class="flex h-screen">
        <aside class="fixed top-0 hidden md:flex md:w-64 bg-gray-800 text-white  dark:text-gray-300 py-6 px-3 flex-shrink-0 flex flex-col h-screen">  <!-- Added fixed and top-0 -->
            <nav class="flex-1">
                @auth
                <div class="mb-2">
                    <p class="text-center text-sm text-gray-400 mt-2">Afregning</p>
                </div>
                <div class="space-y-2">
                    <div>
                        <a href="/invoices" wire:navigate.hover @class(['block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700 hover:text-white', request()->is('invoices') ? 'bg-gray-700' : ''])>
                            Fakturaer
                        </a>
                    </div>

                    <div>
                        <a href="/competitions" wire:navigate.hover @class(['block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700 hover:text-white', request()->is('competitions*') ? 'bg-gray-700' : ''])>
                            Konkurrencer
                        </a>
                    </div>
                </div>
                @else
                    <div class="mb-2">
                        <p class="text-center text-sm text-gray-400 mt-2">Bruger</p>
                    </div>
                    <div class="space-y-2">
                        <div>
                            <a href="/login" wire:navigate.hover @class(['block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700 hover:text-white', request()->is('login') ? 'bg-gray-700' : ''])>
                                Login
                            </a>
                        </div>
                    </div>
                @endauth
            </nav>
        </aside>

        <!-- Page Content Wrapper -->
        <div class="flex-1 flex flex-col md:pl-64">
            <div class = "flex flex-col flex-1 bg-gray-100 dark:bg-gray-700">
                <!-- Page Heading -->
                <header class="bg-white dark:bg-blue-800 shadow dark:text-gray-300 no-print">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-300 leading-tight">
                            {{ $header }}
                        </h2>
                    </div>
                </header>

                <!-- Page Content -->
                <main class="flex-1 py-0">
                    {{ $slot }}
                </main>
            </div>
        </div>
    </div>
</div>
</body>
</html>
