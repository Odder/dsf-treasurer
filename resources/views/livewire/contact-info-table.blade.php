<x-slot:header>
    Personer
</x-slot:header>

<x-mush.layout.container>
    <div></div>

    <x-action-container>
        <x-bladewind::button wire:click="openCreateDialog">Opret person</x-bladewind::button>
    </x-action-container>

    <x-mush.comp.card>
        <x-mush.comp.table>
            <x-slot:header>
                <x-mush.comp.table-th>Navn</x-mush.comp.table-th>
                <x-mush.comp.table-th>Email</x-mush.comp.table-th>
                <x-mush.comp.table-th>Adresse</x-mush.comp.table-th>
                <x-mush.comp.table-th>WCA ID</x-mush.comp.table-th>
            </x-slot:header>

            <x-slot:body>
                @forelse($contacts as $contact)
                    <x-mush.comp.table-tr wire:key="{{ $contact->id }}">
                        <x-mush.comp.table-td>
                            <x-mush.link link="/people/{{ $contact->id }}">
                                {{ $contact->name }}
                            </x-mush.link>
                        </x-mush.comp.table-td>
                        <x-mush.comp.table-td>{{ $contact->email }}</x-mush.comp.table-td>
                        <x-mush.comp.table-td>{{ $contact->address }}</x-mush.comp.table-td>
                        <x-mush.comp.table-td>{{ $contact->wca_id }}</x-mush.comp.table-td>
                    </x-mush.comp.table-tr>
                @empty
                    <x-mush.comp.table-tr>
                        <x-mush.comp.table-td colspan="4">Ingen personer fundet.</x-mush.comp.table-td>
                    </x-mush.comp.table-tr>
                @endforelse
            </x-slot:body>

            <x-slot:footer>
                <div class="px-4 py-3 bg-white dark:bg-gray-800 border-t border-gray-500">
                    {{ $contacts->links() }}
                </div>
            </x-slot:footer>
        </x-mush.comp.table>
    </x-mush.comp.card>

    <livewire:contact-info-create-dialog />
</x-mush.layout.container>
