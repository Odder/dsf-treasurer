@php
    use Carbon\Carbon;
@endphp

<div>
    <x-slot name="header">
        Faktura-oversigt
    </x-slot>

    <x-main-container>
        <x-bladewind::table
            layout="custom"
            divided="thin"
            :data="$invoices->items()"
        >
            <x-slot:header>
                <th>#</th>
                <th>Status</th>
                <th>Konkurrence</th>
                <th>Forening</th>
                <th>Total</th>
                <th>Forfaldsdato</th>
            </x-slot:header>

            <tbody>
            @forelse($invoices->items() as $invoice)
                <tr wire:key="{{ $invoice->id }}" class="dark:bg-gray-700">
                    <td>
                        <a href="/invoices/{{ $invoice->id }}" wire:navigate.hover>
                            {{ $invoice->invoice_number }}
                        </a>
                    </td>

                    <td>
                        @php
                            $statusColor = match ($invoice->status) {
                                'paid' => 'green',
                                'unpaid' => 'yellow',
                                'overdue' => 'red',
                                default => 'gray',
                            };
                            $statusText = match ($invoice->status) {
                                'paid' => 'Betalt',
                                'unpaid' => 'Ubetalt',
                                'overdue' => 'Forfalden',
                                default => 'Kladde',
                            };
                        @endphp
                        <span
                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-{{ $statusColor }}-100 text-{{ $statusColor }}-800">
                        {{ $statusText }}
                    </span>
                    </td>
                    <td>
                        <div>{{ $invoice->competition?->name }}</div>
                    </td>
                    <td>
                        <div>{{ $invoice->association?->name }}</div>
                    </td>
                    <td>
                        <div>{{ number_format($invoice->amount, 2, ',', '.') }}</div>
                    </td>
                    <td>
                        <div>{{ Carbon::parse($invoice->due_at)->format('d/m/Y') }}</div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">
                        <div class="text-sm text-white-500">Ingen fakturaer fundet.</div>
                    </td>
                </tr>
            @endforelse
            </tbody>
        </x-bladewind::table>
        <div class="px-4 py-3 bg-white dark:bg-gray-800 border-t border-gray-500 ">
            {{ $invoices->links() }}
        </div>
    </x-main-container>
</div>
