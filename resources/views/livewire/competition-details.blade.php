<div>
    <x-slot:header>
        {{ $competition->name }}
    </x-slot:header>

    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <strong class="font-bold">Success!</strong>
            <span class="block sm:inline">{{ session('message') }}</span>
        </div>
    @endif

    <x-mush.layout.container>
        <div></div>
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
            @if ($competition->invoices()->exists())
                <x-mush.link link="{{ route('invoices.show', $competition->invoices()->first()) }}">
                    <x-bladewind::button>
                        <x-wca-logo class="mr-2 inline-block" width="25" height="25"/>
                        Se Faktura
                    </x-bladewind::button>
                </x-mush.link>
            @else
                <x-bladewind::button wire:click="generateInvoice">
                    Generér faktura
                </x-bladewind::button>
            @endif
            <a href="https://www.worldcubeassociation.org/competitions/{{ $competition->wca_id }}" target="_blank">
                <x-bladewind::button>
                    <x-wca-logo class="mr-2 inline-block" width="25" height="25"/>
                    View on WCA
                </x-bladewind::button>
            </a>
        </x-action-container>

        <x-mush.grid cols="2">
            <x-mush.comp.card title="Detaljer">
                <div class="p-4">
                    <p>Konkurrence:
                        <a href="https://www.worldcubeassociation.org/competitions/{{ $competition->wca_id }}">
                            {{ $competition->name }}
                        </a>
                    </p>
                    <p>WCA ID: {{ $competition->wca_id }}</p>
                    <p>Startdato: {{ $competition->start_date }}</p>
                    <p>Slutdato: {{ $competition->end_date }}</p>
                    @error('wcif') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>
            </x-mush.comp.card>

            <x-mush.comp.card title="Discipliner">
                <div class="p-4">
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
            </x-mush.comp.card>
        </x-mush.grid>

        <x-mush.comp.card title="Arrangører">
            <div class="p-4">
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
        </x-mush.comp.card>
    </x-mush.layout.container>
</div>
