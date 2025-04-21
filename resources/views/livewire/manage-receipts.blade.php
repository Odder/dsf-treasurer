@php
    use App\Enums\ReceiptStatus;

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

<div>
    <x-slot:header>
        Administrer Udlæg
    </x-slot:header>

    <x-mush.layout.container>
        <div></div>

        <x-mush.comp.card title="Modtaget">
            <x-mush.comp.table>
                <x-slot:header>
                    <x-mush.comp.table-th>Kvittering</x-mush.comp.table-th>
                    <x-mush.comp.table-th>Beløb</x-mush.comp.table-th>
                    <x-mush.comp.table-th>Beskrivelse</x-mush.comp.table-th>
                    <x-mush.comp.table-th>Person</x-mush.comp.table-th>
                    <x-mush.comp.table-th>Bank Info</x-mush.comp.table-th>
                    <x-mush.comp.table-th>Actions</x-mush.comp.table-th>
                </x-slot:header>

                <x-slot:body>
                    @forelse ($receivedReceipts as $receipt)
                        <x-mush.comp.table-tr wire:key="{{ $receipt->id }}">
                            <x-mush.comp.table-td>
                                <a href="{{ Storage::disk('s3')->url($receipt->image_path) }}" target="_blank">
                                    <img src="{{ Storage::disk('s3')->url($receipt->image_path) }}" alt="Receipt"
                                         style="max-width: 100px;">
                                </a>
                            </x-mush.comp.table-td>
                            <x-mush.comp.table-td>{{ number_format($receipt->amount, 2, ',', '.') }}</x-mush.comp.table-td>
                            <x-mush.comp.table-td>{{ $receipt->description }}</x-mush.comp.table-td>
                            <x-mush.comp.table-td>{{ $receipt->user->name }}</x-mush.comp.table-td>
                            <x-mush.comp.table-td>
                                Reg: {{ $receipt->bank_account_reg }}<br>
                                Konto: {{ $receipt->bank_account_number }}
                            </x-mush.comp.table-td>
                            <x-mush.comp.table-td>
                                <div class="flex flex-wrap gap-2">
                                    <x-bladewind::button
                                        wire:click="updateStatus('{{$receipt->id}}', '{{ReceiptStatus::ACCEPTED->value}}')"
                                        size="tiny"
                                        color="blue">
                                        Godkend
                                    </x-bladewind::button>
                                    <x-bladewind::button
                                        wire:click="updateStatus('{{$receipt->id}}', '{{ReceiptStatus::REJECTED->value}}')"
                                        size="tiny"
                                        color="red">
                                        Afvis
                                    </x-bladewind::button>
                                </div>
                            </x-mush.comp.table-td>
                        </x-mush.comp.table-tr>
                    @empty
                        <x-mush.comp.table-tr>
                            <x-mush.comp.table-td colspan="8">Ingen modtaget udlæg fundet.</x-mush.comp.table-td>
                        </x-mush.comp.table-tr>
                    @endforelse
                </x-slot:body>
                <x-slot:footer>
                    <div class="px-4 py-3 bg-white dark:bg-gray-800 border-t border-gray-500">
                        {{ $receivedReceipts->links() }}
                    </div>
                </x-slot:footer>
            </x-mush.comp.table>
        </x-mush.comp.card>

        <x-mush.comp.card title="Godkendt">
            <x-mush.comp.table>
                <x-slot:header>
                    <x-mush.comp.table-th>Kvittering</x-mush.comp.table-th>
                    <x-mush.comp.table-th>Beløb</x-mush.comp.table-th>
                    <x-mush.comp.table-th>Beskrivelse</x-mush.comp.table-th>
                    <x-mush.comp.table-th>Person</x-mush.comp.table-th>
                    <x-mush.comp.table-th>Bank Info</x-mush.comp.table-th>
                    <x-mush.comp.table-th>Actions</x-mush.comp.table-th>
                </x-slot:header>

                <x-slot:body>
                    @forelse ($acceptedReceipts as $receipt)
                        <x-mush.comp.table-tr wire:key="{{ $receipt->id }}">
                            <x-mush.comp.table-td>
                                <a href="{{ Storage::disk('s3')->url($receipt->image_path) }}" target="_blank">
                                    <img src="{{ Storage::disk('s3')->url($receipt->image_path) }}" alt="Receipt"
                                         style="max-width: 100px;">
                                </a>
                            </x-mush.comp.table-td>
                            <x-mush.comp.table-td>{{ number_format($receipt->amount, 2, ',', '.') }}</x-mush.comp.table-td>
                            <x-mush.comp.table-td>{{ $receipt->description }}</x-mush.comp.table-td>
                            <x-mush.comp.table-td>{{ $receipt->user->name }}</x-mush.comp.table-td>
                            <x-mush.comp.table-td>
                                Reg: {{ $receipt->bank_account_reg }}<br>
                                Konto: {{ $receipt->bank_account_number }}
                            </x-mush.comp.table-td>
                            <x-mush.comp.table-td>
                                <div class="flex flex-wrap gap-2">
                                    <x-bladewind::button
                                        wire:click="updateStatus('{{$receipt->id}}', '{{ReceiptStatus::SETTLED->value}}')"
                                        size="tiny"
                                        color="green">
                                        afregn
                                    </x-bladewind::button>
                                    <x-bladewind::button
                                        wire:click="updateStatus('{{$receipt->id}}', '{{ReceiptStatus::REJECTED->value}}')"
                                        size="tiny"
                                        color="red">
                                        Afvis
                                    </x-bladewind::button>
                                </div>
                            </x-mush.comp.table-td>
                        </x-mush.comp.table-tr>
                    @empty
                        <x-mush.comp.table-tr>
                            <x-mush.comp.table-td colspan="8">Ingen godkendte udlæg fundet.</x-mush.comp.table-td>
                        </x-mush.comp.table-tr>
                    @endforelse
                </x-slot:body>
                <x-slot:footer>
                    <div class="px-4 py-3 bg-white dark:bg-gray-800 border-t border-gray-500">
                        {{ $acceptedReceipts->links() }}
                    </div>
                </x-slot:footer>
            </x-mush.comp.table>
        </x-mush.comp.card>

        <x-mush.comp.card title="Lukkede Udlæg">
            <x-mush.comp.table>
                <x-slot:header>
                    <x-mush.comp.table-th>Kvittering</x-mush.comp.table-th>
                    <x-mush.comp.table-th>Beløb</x-mush.comp.table-th>
                    <x-mush.comp.table-th>Beskrivelse</x-mush.comp.table-th>
                    <x-mush.comp.table-th>Person</x-mush.comp.table-th>
                    <x-mush.comp.table-th>Bank Info</x-mush.comp.table-th>
                    <x-mush.comp.table-th>Status</x-mush.comp.table-th>
                </x-slot:header>

                <x-slot:body>
                    @forelse ($closedReceipts as $receipt)
                        <x-mush.comp.table-tr wire:key="{{ $receipt->id }}">
                            <x-mush.comp.table-td>
                                <a href="{{ Storage::disk('s3')->url($receipt->image_path) }}" target="_blank">
                                    <img src="{{ Storage::disk('s3')->url($receipt->image_path) }}" alt="Receipt"
                                         style="max-width: 100px;">
                                </a>
                            </x-mush.comp.table-td>
                            <x-mush.comp.table-td>{{ number_format($receipt->amount, 2, ',', '.') }}</x-mush.comp.table-td>
                            <x-mush.comp.table-td>{{ $receipt->description }}</x-mush.comp.table-td>
                            <x-mush.comp.table-td>{{ $receipt->user->name }}</x-mush.comp.table-td>
                            <x-mush.comp.table-td>
                                Reg: {{ $receipt->bank_account_reg }}<br>
                                Konto: {{ $receipt->bank_account_number }}
                            </x-mush.comp.table-td>
                            <x-mush.comp.table-td>
                                <x-mush.comp.badge :level="$statusLevel[$receipt->status->value]"
                                                   :text="$statusText[$receipt->status->value]"/>
                            </x-mush.comp.table-td>
                        </x-mush.comp.table-tr>
                    @empty
                        <x-mush.comp.table-tr>
                            <x-mush.comp.table-td colspan="8">Ingen lukkede udlæg fundet.</x-mush.comp.table-td>
                        </x-mush.comp.table-tr>
                    @endforelse
                </x-slot:body>
                <x-slot:footer>
                    <div class="px-4 py-3 bg-white dark:bg-gray-800 border-t border-gray-500">
                        {{ $closedReceipts->links() }}
                    </div>
                </x-slot:footer>
            </x-mush.comp.table>
        </x-mush.comp.card>
    </x-mush.layout.container>
</div>
