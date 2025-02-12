<div>
    <x-slot name="header">
        Regional Associations
    </x-slot>

    <x-main-container>
        <x-bladewind::table
            layout="custom"
            divided="thin"
            :data="$regionalAssociations->items()"
        >
            <x-slot:header>
                <th>Name</th>
                <th># Competitions</th>
                <th>Chairman</th>
                <th>Treasurer</th>
            </x-slot:header>

            <tbody>
            @forelse($regionalAssociations as $association)
                <tr wire:key="{{ $association->id }}" class="dark:bg-gray-700">
                    <td>
                        <a href="{{ route('regional-associations.show', $association) }}" wire:navigate.hover>
                            {{ $association->name }}
                        </a>
                    </td>
                    <td>{{ $association->numberOfCompetitions }}</td>
                    <td>{{ $association->chairman?->name }}</td>
                    <td>{{ $association->treasurer?->name }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">Kunne ikke finde nogle foreninger.</td>
                </tr>
            @endforelse
            </tbody>
        </x-bladewind::table>

        <div class="px-4 py-3 bg-white dark:bg-gray-800 border-t border-gray-500">
            {{ $regionalAssociations->links() }}
        </div>
    </x-main-container>
</div>
