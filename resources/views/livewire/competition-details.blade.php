<div>
    <x-slot name="header">
        {{ $competition->name }}
    </x-slot>

    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <strong class="font-bold">Success!</strong>
            <span class="block sm:inline">{{ session('message') }}</span>
        </div>
    @endif

    <x-action-container>
        <div wire:loading wire:target="refetchWcif">
            <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                 viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor"
                      d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        </div>
        <x-bladewind::button
            icon="arrow-path"
            class="relative"
            wire:click="refetchWcif"
            wire:loading.remove
            wire:target="refetchWcif"
        >
            <span>Genhent WCIF</span>
        </x-bladewind::button>
    </x-action-container>

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
                <p>Startdato: {{ $competition->start_date }}</p>
                <p>Slutdato: {{ $competition->end_date }}</p>
                @if ($competition->invoices()->exists())
                    <p>Faktura:
                        <a href="{{ route('invoices.show', $competition->invoices()->first()) }}"
                           class="text-blue-600 hover:underline"
                           wire:navigate.hover
                        >
                            Se Faktura
                            #{{ $competition->invoices()->first()->invoice_number }}</a>
                    </p>
                @else
                    <p class="text-gray-500">Der er ikke nogen faktura endnu.</p>
                    <button wire:click="generateInvoice"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Generér faktura
                    </button>
                @endif
                @error('wcif') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
        </x-slot>
        <x-slot name="right">
            <div class="p-4">
                <h4 class="text-md font-semibold mb-2">Discipliner</h4>
                <ul>
                    @if($events)
                        <ul class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-2">
                            @foreach($events as $event)
                                <li>{{ $event }}</li>
                            @endforeach
                        </ul>
                    @else
                        <li>Ingen discipliner fundet</li>
                    @endif
                </ul>
            </div>
        </x-slot>
    </x-two-column-container>

    <!-- Registered Competitors Card -->
    <x-main-container>
        <div class="p-4">
            <h4 class="text-md font-semibold mb-4">Arrangører</h4>

            <!-- All Competitors Table -->
            <div class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-6 lg:grid-cols-8 gap-4">
                @forelse($organisers as $organiser)
                    <div class="text-center">
                        @if($organiser->get('avatarUrl'))
                            <img src="{{ $organiser->get('avatarUrl') }}" alt="{{ $organiser->get('name') }}"
                                 class="rounded-full h-16 w-16 mx-auto object-cover">
                        @else
                            <div class="rounded-full h-16 w-16 mx-auto bg-gray-300"></div>
                        @endif
                        <a href="https://www.worldcubeassociation.org/persons/{{ $organiser->get('wcaId') }}"
                           target="_blank" class="text-sm text-gray-500 hover:text-blue-600">
                            {{ $organiser->get('name') }}
                        </a>
                    </div>
                @empty
                    <div>Ingen arrangører fundet</div>
                @endforelse
            </div>
        </div>
    </x-main-container>
</div>
