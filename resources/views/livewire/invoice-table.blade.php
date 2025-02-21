@php
    use Carbon\Carbon;

    $statusFilterOptions = [
        '' => 'Alle',
        'paid' => 'Betalt',
        'unpaid' => 'Ubetalt',
        'overdue' => 'Forfalden',
        'draft' => 'Kladde',
    ]
@endphp

<x-slot:header>
    Faktura-oversigt
</x-slot:header>

<x-mush.layout.container>
    <div></div>

    <x-mush.comp.card>
        <div class="p-4 flex flex-wrap gap-4">
            <div>
                <x-mush.form.select
                    id="statusFilter"
                    label="Status"
                    :items="$statusFilterOptions"
                />
            </div>

            <div>
                <x-mush.form.select
                    id="associationFilter"
                    label="Forening"
                    default="Alle"
                    :items="$associations->pluck('name', 'id')"
                />
            </div>
        </div>

        <x-mush.comp.table>
            <x-slot:header>
                <x-mush.comp.table-th>#</x-mush.comp.table-th>
                <x-mush.comp.table-th>Status</x-mush.comp.table-th>
                <x-mush.comp.table-th>Konkurrence</x-mush.comp.table-th>
                <x-mush.comp.table-th>Forening</x-mush.comp.table-th>
                <x-mush.comp.table-th>Total</x-mush.comp.table-th>
                <x-mush.comp.table-th>Forfaldsdato</x-mush.comp.table-th>
                <x-mush.comp.table-th>Actions</x-mush.comp.table-th>
            </x-slot:header>

            <x-slot:body>
                @forelse($invoices->items() as $invoice)
                    <x-mush.comp.table-tr wire:key="{{ $invoice->id }}">
                        <x-mush.comp.table-td>
                            <x-mush.link link="/invoices/{{ $invoice->id }}">
                                #{{ $invoice->invoice_number }}
                            </x-mush.link>
                        </x-mush.comp.table-td>

                        <x-mush.comp.table-td>
                            @php
                                $level = match ($invoice->status) {
                                    'paid' => 'success',
                                    'unpaid' => 'warning',
                                    'overdue' => 'danger',
                                    default => 'gray',
                                };
                                $statusText = match ($invoice->status) {
                                    'paid' => 'Betalt',
                                    'unpaid' => 'Ubetalt',
                                    'overdue' => 'Forfalden',
                                    default => 'Kladde',
                                };
                            @endphp
                            <x-mush.comp.badge :level="$level" :text="$statusText" />
                        </x-mush.comp.table-td>

                        <x-mush.comp.table-td>
                            <x-mush.link link="/competitions/{{ $invoice->competition->id }}">
                                {{ $invoice->competition->name }}
                            </x-mush.link>
                        </x-mush.comp.table-td>

                        <x-mush.comp.table-td>
                            @if ($invoice->association)
                                <x-mush.link link="/regional-associations/{{ $invoice->association->id }}">
                                    {{ $invoice->association->name }}
                                </x-mush.link>
                            @endif
                        </x-mush.comp.table-td>

                        <x-mush.comp.table-td class="text-right">
                            {{ number_format($invoice->amount, 2, ',', '.') }}
                        </x-mush.comp.table-td>

                        <x-mush.comp.table-td>
                            {{ Carbon::parse($invoice->due_at)->format('d/m/Y') }}
                        </x-mush.comp.table-td>

                        <x-mush.comp.table-td>
                            <x-mush.link link="/invoices/{{ $invoice->id }}">
                                <x-bladewind::button size="tiny">
                                    Vis faktura
                                </x-bladewind::button>
                            </x-mush.link>
                        </x-mush.comp.table-td>
                    </x-mush.comp.table-tr>
                @empty
                    <x-mush.comp.table-tr>
                        <x-mush.comp.table-td colspan="7">
                            <div class="text-sm text-white-500">Ingen fakturaer fundet.</div>
                        </x-mush.comp.table-td>
                    </x-mush.comp.table-tr>
                @endforelse
            </x-slot:body>

            <x-slot:footer>
                <div class="px-4 py-3 bg-white dark:bg-gray-800 border-t border-gray-500">
                    {{ $invoices->links() }}
                </div>
            </x-slot:footer>
        </x-mush.comp.table>
    </x-mush.comp.card>
</x-mush.layout.container>
