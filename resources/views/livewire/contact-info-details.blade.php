<div>
    <x-slot:header>
        Person: {{ $contactInfo->name }}
    </x-slot:header>

    <x-mush.layout.container>
        <div></div>

        <x-action-container>
            <x-bladewind::button wire:click="openEditDialog">
                Opdater
            </x-bladewind::button>
        </x-action-container>

        <x-mush.comp.card title="Personlige detaljer">
            <div class="p-4">
                <p>Navn: {{ $contactInfo->name }}</p>
                <p>Email: {{ $contactInfo->email }}</p>
                <p>Adresse: {{ $contactInfo->address }}</p>
                <p>WCA ID: {{ $contactInfo->wca_id }}</p>
            </div>
        </x-mush.comp.card>

        <x-mush.comp.card title="Foreninger">
            <x-mush.comp.table>
                <x-slot:header>
                    <x-mush.comp.table-th>Forening</x-mush.comp.table-th>
                    <x-mush.comp.table-th>Rolle</x-mush.comp.table-th>
                </x-slot:header>
                <x-slot:body>
                    @forelse ($associations as $association)
                        <x-mush.comp.table-tr wire:key="{{ $association->id }}">
                            <x-mush.comp.table-td>
                                <x-mush.link link="/regional-associations/{{ $association->id }}">
                                    {{ $association->name }}
                                </x-mush.link>
                            </x-mush.comp.table-td>
                            <x-mush.comp.table-td>{{ $association->pivot->role }}</x-mush.comp.table-td>
                        </x-mush.comp.table-tr>
                    @empty
                        <x-mush.comp.table-tr>
                            <x-mush.comp.table-td colspan="2">Ingen foreninger fundet.</x-mush.comp.table-td>
                        </x-mush.comp.table-tr>
                    @endforelse
                </x-slot:body>
            </x-mush.comp.table>
        </x-mush.comp.card>

        <livewire:contact-info-edit-dialog :contactInfo="$contactInfo" :key="$contactInfo->id"/>
    </x-mush.layout.container>
</div>
