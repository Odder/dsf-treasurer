<x-app-layout>
    <x-slot name="header">
        {{ $competition->name }}
    </x-slot>

    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <strong class="font-bold">Success!</strong>
            <span class="block sm:inline">{{ session('message') }}</span>
        </div>
    @endif

    <x-two-column-container>
        <x-slot name="left">
            <div class="p-4">
                <h4 class="text-md font-semibold mb-2">Detaljer</h4>
                <p>Konkurrence:
                    <a href="https://www.worldcubeassociation.org/competitions/{{ $competition->wca_id }}">
                    {{ $competition->name }}
                    </a>
                </p>
                <p>WCA ID: {{ $competition->wca_id }}</p>
                <p>Start Date: {{ $competition->start_date }}</p>
                <p>End Date: {{ $competition->end_date }}</p>
                @if ($competition->invoices()->exists())
                    <p>Invoice:
                        <a href="{{ route('invoices.show', $competition->invoices()->first()) }}"
                           class="text-blue-600 hover:underline">View Invoice
                            #{{ $competition->invoices()->first()->invoice_number }}</a>
                    </p>
                @else
                    <p class="text-gray-500">No invoice generated for this competition yet.</p>
                    <button wire:click="generateInvoice" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Generate Invoice
                    </button>
                @endif

                <button wire:click="refetchWcif" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Refetch WCIF
                </button>
                @error('wcif') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
        </x-slot>
        <x-slot name="right">
            <div class="p-4">
                <h4 class="text-md font-semibold">Events Schedule</h4>
                <ul>
                    @if($events)
                        @foreach($events as $event)
                            <li>{{ $event }}</li>
                        @endforeach
                    @else
                        <li>No Events Found</li>
                    @endif
                </ul>
            </div>
        </x-slot>
    </x-two-column-container>

    <!-- Registered Competitors Card -->
    <x-main-container>
        <div class="p-4">
            <h4 class="text-md font-semibold">Registered Competitors</h4>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mt-4">
                @if($competitors)
                    @foreach($competitors->take(6) as $competitor)
                        <div class="text-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mx-auto text-gray-400" fill="none"
                                 viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M5.121 17.804A13 13 0 0110 16.25a13 13 0 013.879 1.554m-.999-3.467l-1.105-2.905a1 1 0 00-.948-.684H6.353a1 1 0 00-.948.684l-1.105 2.905a13 13 0 01.999 3.467m7.328 0l-1.105 2.905a1 1 0 00.948.684h4.076a1 1 0 00.948-.684l-1.105-2.905m-4.66-3.467a3.3 3.3 0 01-3.3 3.3H5A3.3 3.3 0 011.7 11a3.3 3.3 0 013.3-3.3h1.685a3.3 3.3 0 013.3 3.3z"/>
                            </svg>
                            <p class="text-sm text-gray-500">{{ $competitor->name }}</p>
                            <p class="text-xs text-gray-400">WCA ID: {{ $competitor->wcaId }}</p>
                        </div>
                    @endforeach
                @else
                    <div>No Competitors Found</div>
                @endif
            </div>
            <div class="mt-4 text-center">
                <a href="#" class="text-blue-600 hover:underline">View All Competitors</a>
            </div>
        </div>

    </x-main-container>
</x-app-layout>
