<div>
    <x-slot name="header">
        Forening: {{ $regionalAssociation->name }}
    </x-slot>

    <x-action-container>
        <a href="https://danskspeedcubingforening.dk/nyttig-info/">
            <x-bladewind::button class="relative">
                <span>Se forening på DSF</span>
            </x-bladewind::button>
        </a>
    </x-action-container>

    <x-main-container>
        <div class="p-4">
            <h2 class="text-xl font-semibold mb-4">Detaljer</h2>
            <p>Navn: {{ $regionalAssociation->name }}</p>
            <p>Formand: {{ $regionalAssociation->chairman?->name ?? 'N/A' }}
                ({{ $regionalAssociation->chairman?->email ?? 'N/A' }})</p>
            <p>Kasserer: {{ $regionalAssociation->treasurer?->name ?? 'N/A' }}
                ({{ $regionalAssociation->treasurer?->email ?? 'N/A' }})</p>
            <p>Udestående: {{ number_format($regionalAssociation->currentOutstanding(), 2) }}</p>
        </div>
    </x-main-container>

    @if ($unpaidInvoices->isNotEmpty())
        <x-main-container>
            <div class="p-4">
                <h3 class="text-lg font-semibold">Ubetalte fakturaer</h3>
            </div>
            <x-bladewind::table
                layout="custom"
                divided="thin"
            >
                <x-slot name="header">
                    <th>#</th>
                    <th>Konkurrence</th>
                    <th>Beløb</th>
                    <th>Actions</th>
                </x-slot>
                @foreach($unpaidInvoices as $invoice)
                    <tr wire:key="{{ $invoice->id }}" class="dark:bg-gray-700">
                        <td>
                            <a href="/invoices/{{ $invoice->id }}" wire:navigate.hover>
                                #{{ $invoice->invoice_number }}
                            </a>
                        </td>
                        <td>
                            <a href="/competitions/{{ $invoice->competition->id }}" wire:navigate.hover>
                                {{ $invoice->competition->name }}
                            </a>
                        </td>
                        <td class="text-right">{{ number_format($invoice->amount, 2) }}</td>
                        <td>
                            <a href="/invoices/{{ $invoice->id }}" wire:navigate.hover>
                                <x-bladewind::button size="tiny">
                                    Vis faktura
                                </x-bladewind::button>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </x-bladewind::table>
        </x-main-container>
    @endif

    @if ($paidInvoices->isNotEmpty())
        <x-main-container>
            <div class="p-4">
                <h3 class="text-lg font-semibold">Betalte fakturaer</h3>
            </div>
            <x-bladewind::table
                layout="custom"
                divided="thin"
            >
                <x-slot name="header">
                    <th>#</th>
                    <th>Konkurrence</th>
                    <th>Beløb</th>
                    <th>Actions</th>
                </x-slot>
                @foreach($paidInvoices as $invoice)
                    <tr wire:key="{{ $invoice->id }}" class="dark:bg-gray-700">
                        <td>
                            <a href="/invoices/{{ $invoice->id }}" wire:navigate.hover>
                                #{{ $invoice->invoice_number }}
                            </a>
                        </td>
                        <td>
                            <a href="/competitions/{{ $invoice->competition->id }}" wire:navigate.hover>
                                {{ $invoice->competition->name }}
                            </a>
                        </td>
                        <td class="text-right">{{ number_format($invoice->amount, 2) }}</td>
                        <td>
                            <a href="/invoices/{{ $invoice->id }}" wire:navigate.hover>
                                <x-bladewind::button size="tiny">
                                    Vis faktura
                                </x-bladewind::button>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </x-bladewind::table>
        </x-main-container>
    @endif

    @if ($upcomingCompetitions->isNotEmpty())
        <x-main-container>
            <div class="p-4">
                <h3 class="text-lg font-semibold">Kommende konkurrencer</h3>
            </div>
            <x-bladewind::table
                layout="custom"
                divided="thin"
            >
                <x-slot name="header">
                    <th>Navn</th>
                    <th>Startdato</th>
                    <th>Slutdato</th>
                </x-slot>
                @foreach($upcomingCompetitions as $competition)
                    <tr wire:key="{{ $competition->id }}" class="dark:bg-gray-700">
                        <td>{{ $competition->name }}</td>
                        <td>{{ $competition->start_date }}</td>
                        <td>{{ $competition->end_date }}</td>
                    </tr>
                @endforeach
            </x-bladewind::table>
        </x-main-container>
    @endif
</div>
