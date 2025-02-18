@php
    $statusLevel = [
        'reported' => 'draft',
        'accepted' => 'info',
        'rejected' => 'danger',
        'settled' => 'success',
    ];
    $statusText = [
        'reported' => 'Indsendt',
        'accepted' => 'Godkendt',
        'rejected' => 'Afvist',
        'settled' => 'Afregnet',
    ];
@endphp

<x-slot:header>
    Mine udlæg
</x-slot:header>

<x-mush.layout.container>
    <div></div>
    <x-mush.comp.card>

        <x-mush.comp.table>
            <x-slot:header>
                <x-mush.comp.table-th>Kvittering</x-mush.comp.table-th>
                <x-mush.comp.table-th>Beløb</x-mush.comp.table-th>
                <x-mush.comp.table-th>Beskrivelse</x-mush.comp.table-th>
                <x-mush.comp.table-th>Forening</x-mush.comp.table-th>
                <x-mush.comp.table-th>Konkurrence</x-mush.comp.table-th>
                <x-mush.comp.table-th>Status</x-mush.comp.table-th>
                <x-mush.comp.table-th>Actions</x-mush.comp.table-th>
            </x-slot:header>

            <x-slot:body>
                @forelse ($receipts as $receipt)
                    <x-mush.comp.table-tr wire:key="{{ $receipt->id }}">
                        <x-mush.comp.table-td>
                            <a href="{{ Storage::disk('s3')->url($receipt->image_path) }}" target="_blank">
                                <img src="{{ Storage::disk('s3')->url($receipt->image_path) }}" alt="Receipt" style="max-width: 100px;">
                            </a>
                        </x-mush.comp.table-td>
                        <x-mush.comp.table-td>{{ number_format($receipt->amount, 2, ',', '.') }}</x-mush.comp.table-td>
                        <x-mush.comp.table-td>{{ $receipt->description }}</x-mush.comp.table-td>
                        <x-mush.comp.table-td>
                            @if ($receipt->association)
                                <x-mush.link link="/regional-associations/{{ $receipt->association->id }}">
                                    {{ $receipt->association->name }}
                                </x-mush.link>
                            @endif
                        </x-mush.comp.table-td>
                        <x-mush.comp.table-td>
                            @if ($receipt->competition)
                                <x-mush.link link="/competitions/{{ $receipt->competition->id }}">
                                    {{ $receipt->competition->name }}
                                </x-mush.link>
                            @endif
                        </x-mush.comp.table-td>
                        <x-mush.comp.table-td>
                            <x-mush.comp.badge :level="$statusLevel[$receipt->status]" :text="$statusText[$receipt->status]" />
                        </x-mush.comp.table-td>
                        <x-mush.comp.table-td>
                            @if($receipt->status == 'reported' || $receipt->status == 'accepted')
                                <x-bladewind::button wire:click="updateStatus('{{$receipt->id}}', 'rejected')" size="tiny" color="red">Annulér</x-bladewind::button>
                            @endif
                        </x-mush.comp.table-td>
                    </x-mush.comp.table-tr>
                @empty
                    <x-mush.comp.table-tr>
                        <x-mush.comp.table-td colspan="7">Ingen udlæg fundet.</x-mush.comp.table-td>
                    </x-mush.comp.table-tr>
                @endforelse
            </x-slot:body>
        </x-mush.comp.table>
    </x-mush.comp.card>
</x-mush.layout.container>
