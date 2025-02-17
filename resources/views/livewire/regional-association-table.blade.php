<div>
    <x-slot:header>
        Regionale foreninger
    </x-slot:header>

    <x-mush.layout.container>
        <div></div>

        <x-mush.comp.card>
            <x-mush.comp.table>
                <x-slot:header>
                    <x-mush.comp.table-th>Navn</x-mush.comp.table-th>
                    <x-mush.comp.table-th># Konkurrencer</x-mush.comp.table-th>
                    <x-mush.comp.table-th>Formand</x-mush.comp.table-th>
                    <x-mush.comp.table-th>Næstformand</x-mush.comp.table-th>
                    <x-mush.comp.table-th>Kasserer</x-mush.comp.table-th>
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
                            <x-mush.comp.table-td>{{ $association->chairman->first()?->name }}</x-mush.comp.table-td>
                            <x-mush.comp.table-td>{{ $association->viceChair->first()?->name }}</x-mush.comp.table-td>
                            <x-mush.comp.table-td>{{ $association->treasurer->first()?->name }}</x-mush.comp.table-td>
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
