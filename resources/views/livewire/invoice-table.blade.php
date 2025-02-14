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
                <th>Actions</th>
            </x-slot:header>

            <tbody>
            @forelse($invoices->items() as $invoice)
                <tr wire:key="{{ $invoice->id }}" class="dark:bg-gray-700">
                    <td>
                        <a href="/invoices/{{ $invoice->id }}" wire:navigate.hover>
                            #{{ $invoice->invoice_number }}
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
                        <a href="/competitions/{{ $invoice->competition->id }}" wire:navigate.hover>
                            {{ $invoice->competition->name }}
                        </a>
                    </td>
                    <td>
                        @if ($invoice->association)
                            <a href="/regional-associations/{{ $invoice->association->id }}" wire:navigate.hover>
                                {{ $invoice->association->name }}
                            </a>
                        @endif
                    </td>
                    <td>
                        <div class="text-right">{{ number_format($invoice->amount, 2, ',', '.') }}</div>
                    </td>
                    <td>
                        <div>{{ Carbon::parse($invoice->due_at)->format('d/m/Y') }}</div>
                    </td>
                    <td>
                        <a href="/invoices/{{ $invoice->id }}" wire:navigate.hover>
                            <x-bladewind::button size="tiny">
                                Vis faktura
                            </x-bladewind::button>
                        </a>
                    </td>
                </tr>
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
