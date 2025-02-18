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
    <link href="{{ asset('vendor/bladewind/css/animate.min.css') }}" rel="stylesheet"/>
    <link href="{{ asset('vendor/bladewind/css/bladewind-ui.min.css') }}" rel="stylesheet"/>
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
        <x-mush.layout.menu>
{{--            <x-slot name="header">--}}
{{--                <h2 class="font-semibold size-7 block">DSF KASSERER!</h2>--}}
{{--            </x-slot>--}}
            @auth
                @if(auth()->user()->isMemberOfAssociation())
                    <x-mush.layout.menu-group title="Afregning">
                        <x-mush.layout.menu-item title="Fakturaer" link="/invoices" match="invoice"/>
                    </x-mush.layout.menu-group>
                @endif
                <x-mush.layout.menu-group title="Konkurrencer">
                    <x-mush.layout.menu-item title="Konkurrencer" link="/competitions" match="competitions*"/>
                </x-mush.layout.menu-group>
                <x-mush.layout.menu-group title="Foreninger">
                    <x-mush.layout.menu-item title="Regionale foreninger" link="/regional-associations"
                                             match="regional-associations"/>
                    @if($contact = auth()->user()->contact)
                        @foreach($contact->associations as $association)
                            <x-mush.layout.menu-item :title="$association->name"
                                                     link="/regional-associations/{{ $association->id }}"
                                                     match="regional-associations/{{ $association->id }}"/>
                        @endforeach
                    @endif
                </x-mush.layout.menu-group>
                <x-mush.layout.menu-group title="Udlæg">
                    <x-mush.layout.menu-item title="Opret udlæg" link="/receipts/upload" match="receipts/upload"/>
                    <x-mush.layout.menu-item title="Mine Udlæg" link="/me/receipts" match="me/receipts"/>
                </x-mush.layout.menu-group>
            @else
                <x-mush.layout.menu-group title="Bruger">
                    <x-mush.layout.menu-item title="Log ind" link="/login" match="login"/>
                </x-mush.layout.menu-group>
            @endif
        </x-mush.layout.menu>

        <!-- Page Content Wrapper -->
        <div class="flex-1 flex flex-col md:pl-64">
            <div class="flex flex-col flex-1 bg-gray-100 dark:bg-gray-700">
                <!-- Page Heading -->
                <x-mush.layout.header header="{{ $header }}"/>

                <!-- Page Content -->
                <main class="flex-1 py-0 pb-10">
                    {{ $slot }}
                </main>
            </div>
        </div>
    </div>
</div>
</body>
</html>
