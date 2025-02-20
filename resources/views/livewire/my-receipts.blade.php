@php
    use App\Enums\ReceiptStatus;

    $statusLevel = [
        ReceiptStatus::REPORTED->value => 'draft',
        ReceiptStatus::ACCEPTED->value => 'info',
        ReceiptStatus::REJECTED->value => 'danger',
        ReceiptStatus::SETTLED->value => 'success',
    ];
    $statusText = [
        ReceiptStatus::REPORTED->value => 'Indsendt',
        ReceiptStatus::ACCEPTED->value => 'Godkendt',
        ReceiptStatus::REJECTED->value => 'Afvist',
        ReceiptStatus::SETTLED->value => 'Afregnet',
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
                            <x-mush.comp.badge :level="$statusLevel[$receipt->status->value]" :text="$statusText[$receipt->status->value]" />
                        </x-mush.comp.table-td>
                        <x-mush.comp.table-td>
                            @if($receipt->status == ReceiptStatus::REPORTED || $receipt->status == ReceiptStatus::ACCEPTED)
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
