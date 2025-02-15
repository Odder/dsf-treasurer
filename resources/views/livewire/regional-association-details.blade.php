<div>
    <x-slot:header>
        Forening: {{ $regionalAssociation->name }}
    </x-slot:header>

    <x-mush.layout.container>
        <x-action-container>
            <a href="https://danskspeedcubingforening.dk/nyttig-info/">
                <x-bladewind::button class="relative">
                    <span>Se forening på DSF</span>
                </x-bladewind::button>
            </a>
        </x-action-container>

        <x-mush.comp.card title="Detaljer">
            <div class="p-4 pt-0">
                <p>Navn: {{ $regionalAssociation->name }}</p>
                <p>Formand: {{ $regionalAssociation->chairman?->name ?? 'N/A' }}
                    ({{ $regionalAssociation->chairman?->email ?? 'N/A' }})</p>
                <p>Kasserer: {{ $regionalAssociation->treasurer?->name ?? 'N/A' }}
                    ({{ $regionalAssociation->treasurer?->email ?? 'N/A' }})</p>
                <p>Udestående: {{ number_format($regionalAssociation->currentOutstanding(), 2) }}</p>
            </div>
        </x-mush.comp.card>

        @if ($unpaidInvoices->isNotEmpty())
            <x-mush.comp.card title="Ubetalte fakturaer">
                <x-mush.comp.table>
                    <x-slot:header>
                        <x-mush.comp.table-th>#</x-mush.comp.table-th>
                        <x-mush.comp.table-th>Konkurrence</x-mush.comp.table-th>
                        <x-mush.comp.table-th>Beløb</x-mush.comp.table-th>
                        <x-mush.comp.table-th>Actions</x-mush.comp.table-th>
                    </x-slot:header>
                    <x-slot:body>
                        @foreach($unpaidInvoices as $invoice)
                            <x-mush.comp.table-tr wire:key="{{ $invoice->id }}">
                                <x-mush.comp.table-td>
                                    <x-mush.link link="/invoices/{{ $invoice->id }}">
                                        #{{ $invoice->invoice_number }}
                                    </x-mush.link>
                                </x-mush.comp.table-td>
                                <x-mush.comp.table-td>
                                    <x-mush.link link="/invoices/{{ $invoice->competition->id }}">
                                        {{ $invoice->competition->name }}
                                    </x-mush.link>
                                </x-mush.comp.table-td>
                                <x-mush.comp.table-td class="text-right">
                                    {{ number_format($invoice->amount, 2) }}
                                </x-mush.comp.table-td>
                                <x-mush.comp.table-td>
                                    <x-mush.link link="/invoices/{{ $invoice->id }}">
                                        <x-bladewind::button size="tiny">
                                            Vis faktura
                                        </x-bladewind::button>
                                    </x-mush.link>
                                </x-mush.comp.table-td>
                            </x-mush.comp.table-tr>
                        @endforeach
                    </x-slot:body>
                </x-mush.comp.table>
            </x-mush.comp.card>
        @endif

        @if ($paidInvoices->isNotEmpty())
            <x-mush.comp.card title="Betalte fakturaer">
                <x-mush.comp.table>
                    <x-slot:header>
                        <x-mush.comp.table-th>#</x-mush.comp.table-th>
                        <x-mush.comp.table-th>Konkurrence</x-mush.comp.table-th>
                        <x-mush.comp.table-th>Beløb</x-mush.comp.table-th>
                        <x-mush.comp.table-th>Actions</x-mush.comp.table-th>
                    </x-slot:header>
                    <x-slot:body>
                        @foreach($paidInvoices as $invoice)
                            <x-mush.comp.table-tr wire:key="{{ $invoice->id }}">
                                <x-mush.comp.table-td>
                                    <x-mush.link link="/invoices/{{ $invoice->id }}">
                                        #{{ $invoice->invoice_number }}
                                    </x-mush.link>
                                </x-mush.comp.table-td>
                                <x-mush.comp.table-td>
                                    <x-mush.link link="/invoices/{{ $invoice->competition->id }}">
                                        {{ $invoice->competition->name }}
                                    </x-mush.link>
                                </x-mush.comp.table-td>
                                <x-mush.comp.table-td class="text-right">
                                        {{ number_format($invoice->amount, 2) }}
                                </x-mush.comp.table-td>
                                <x-mush.comp.table-td>
                                    <x-mush.link link="/invoices/{{ $invoice->id }}">
                                        <x-bladewind::button size="tiny">
                                            Vis faktura
                                        </x-bladewind::button>
                                    </x-mush.link>
                                </x-mush.comp.table-td>
                            </x-mush.comp.table-tr>
                        @endforeach
                    </x-slot:body>
                </x-mush.comp.table>
            </x-mush.comp.card>
        @endif

        @if ($upcomingCompetitions->isNotEmpty())
            <x-mush.comp.card title="Kommende konkurrencer">
                <x-mush.comp.table>
                    <x-slot:header>
                        <x-mush.comp.table-th>Navn</x-mush.comp.table-th>
                        <x-mush.comp.table-th>Startdato</x-mush.comp.table-th>
                        <x-mush.comp.table-th>Slutdato</x-mush.comp.table-th>
                    </x-slot:header>
                    <x-slot:body>
                        @foreach($upcomingCompetitions as $competition)
                            <x-mush.comp.table-tr wire:key="{{ $competition->id }}">
                                <x-mush.comp.table-td>
                                    {{ $competition->name }}
                                </x-mush.comp.table-td>
                                <x-mush.comp.table-td>
                                    {{ $competition->start_date }}
                                </x-mush.comp.table-td>
                                <x-mush.comp.table-td>
                                    {{ $competition->end_date }}
                                </x-mush.comp.table-td>
                            </x-mush.comp.table-tr>
                        @endforeach
                    </x-slot:body>
                </x-mush.comp.table>
            </x-mush.comp.card>
        @endif
    </x-mush.layout.container>
</div>
