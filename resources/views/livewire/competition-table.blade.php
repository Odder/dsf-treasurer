@php
    use Carbon\Carbon;
@endphp

<x-slot:header>
    Konkurrence-oversigt
</x-slot:header>

<x-mush.layout.container>
    <div></div>
    <x-mush.comp.card>
        <x-mush.comp.table>
            <x-slot:header>
                <x-mush.comp.table-th>Navn</x-mush.comp.table-th>
                <x-mush.comp.table-th>Forening</x-mush.comp.table-th>
                <x-mush.comp.table-th>Deltagere</x-mush.comp.table-th>
                <x-mush.comp.table-th>Dato</x-mush.comp.table-th>
            </x-slot:header>

            <x-slot:body>
                @foreach($competitions as $competition)
                    <x-mush.comp.table-tr wire:key="{{ $competition->id }}">
                        <x-mush.comp.table-td>
                            <x-mush.link link="/competitions/{{ $competition->id }}">
                                {{ $competition->name }}
                            </x-mush.link>
                        </x-mush.comp.table-td>

                        <x-mush.comp.table-td>
                            @if($competition->billingAssociation)
                                <x-mush.link
                                    link="/regional-associations/{{ $competition->billingAssociation->id }}">
                                    {{ $competition->billingAssociation->name }}
                                </x-mush.link>
                            @endif
                        </x-mush.comp.table-td>
                        <x-mush.comp.table-td>
                            {{ $competition->invoices->first()?->participants }}
                        </x-mush.comp.table-td>
                        <x-mush.comp.table-td>
                            {{ Carbon::parse($competition->start_date)->format('d/m/Y') }}
                        </x-mush.comp.table-td>
                    </x-mush.comp.table-tr>
                @endforeach
            </x-slot:body>

            <x-slot:footer>
                <div class="px-4 py-3 bg-white dark:bg-gray-800 border-t border-gray-500 ">
                    {{ $competitions->links() }}
                </div>
            </x-slot:footer>
        </x-mush.comp.table>
    </x-mush.comp.card>
</x-mush.layout.container>
