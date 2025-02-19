<div>
    <x-slot:header>
        Forening: {{ $regionalAssociation->name }}
    </x-slot:header>

    <x-mush.layout.container>
        <div></div>

        <x-action-container>
            <a href="https://danskspeedcubingforening.dk/nyttig-info/">
                <x-bladewind::button class="relative">
                    <span>Se forening på DSF</span>
                </x-bladewind::button>
            </a>
            @if(auth()->user()->isDSFBoardMember())
                <x-mush.link link="{{ route('regional-associations.edit-board', $regionalAssociation) }}">
                    <x-bladewind::button>
                        Opdater Bestyrelse
                    </x-bladewind::button>
                </x-mush.link>
            @endif
        </x-action-container>

        <x-mush.grid cols="2">
            <x-mush.comp.card title="Detaljer">
                <div class="p-4 pt-0">
                    <p>Navn: {{ $regionalAssociation->name }}</p>
                    <p>Antal konkurrencer: {{ $regionalAssociation->competitions()->count() }}</p>
                    <p>Udestående: {{ number_format($regionalAssociation->currentOutstanding(), 2) }}</p>
                </div>
            </x-mush.comp.card>

            <x-mush.comp.card title="Bestyrelse">
                <div class="p-4 pt-0">
                    <p>Formand: {{ $chairman?->name ?? 'N/A' }}</p>
                    <p>Næstformand: {{ $viceChair?->name ?? 'N/A' }}</p>
                    <p>Kasserer: {{ $treasurer?->name ?? 'N/A' }}</p>
                    <p>Revisor: {{ $accountant?->name ?? 'N/A' }}</p>
                </div>
            </x-mush.comp.card>
        </x-mush.grid>

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
                                    <x-mush.link link="/competitions/{{ $invoice->competition->id }}">
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
                    <x-slot:footer>
                        <div class="px-4 py-3 bg-white dark:bg-gray-800 border-t border-gray-500">
                            {{ $unpaidInvoices->links() }}
                        </div>
                    </x-slot:footer>
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
                                    <x-mush.link link="/competitions/{{ $invoice->competition->id }}">
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
                    <x-slot:footer>
                        <div class="px-4 py-3 bg-white dark:bg-gray-800 border-t border-gray-500">
                            {{ $paidInvoices->links() }}
                        </div>
                    </x-slot:footer>
                </x-mush.comp.table>
            </x-mush.comp.card>
        @endif
    </x-mush.layout.container>
</div>
