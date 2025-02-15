<div>
    <x-slot:header>
        Regional Associations
    </x-slot:header>

    <x-mush.layout.container>
        <div></div>

        <x-mush.comp.card>
            <x-mush.comp.table>
                <x-slot:header>
                    <x-mush.comp.table-th>Name</x-mush.comp.table-th>
                    <x-mush.comp.table-th># Competitions</x-mush.comp.table-th>
                    <x-mush.comp.table-th>Chairman</x-mush.comp.table-th>
                    <x-mush.comp.table-th>Treasurer</x-mush.comp.table-th>
                </x-slot:header>

                <x-slot:body>
                    @forelse($regionalAssociations as $association)
                        <x-mush.comp.table-tr wire:key="{{ $association->id }}" class="dark:bg-gray-700">
                            <x-mush.comp.table-td>
                                <x-mush.link link="{{ route('regional-associations.show', $association) }}">
                                    {{ $association->name }}
                                </x-mush.link>
                            </x-mush.comp.table-td>
                            <x-mush.comp.table-td>{{ $association->competitions?->count() }}</x-mush.comp.table-td>
                            <x-mush.comp.table-td>{{ $association->chairman?->name }}</x-mush.comp.table-td>
                            <x-mush.comp.table-td>{{ $association->treasurer?->name }}</x-mush.comp.table-td>
                        </x-mush.comp.table-tr>
                    @empty
                        <x-mush.comp.table-tr>
                            <x-mush.comp.table-td colspan="4">Kunne ikke finde nogle foreninger.</x-mush.comp.table-td>
                        </x-mush.comp.table-tr>
                    @endforelse
                </x-slot:body>

                <x-slot:footer>
                    <div class="px-4 py-3 bg-white dark:bg-gray-800 border-t border-gray-500">
                        {{ $regionalAssociations->links() }}
                    </div>
                </x-slot:footer>
            </x-mush.comp.table>
        </x-mush.comp.card>
    </x-mush.layout.container>
</div>
