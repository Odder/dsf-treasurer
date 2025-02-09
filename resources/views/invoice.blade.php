<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <script src="https://cdn.tailwindcss.com"></script>

</head>
<body class="bg-gray-100 text-gray-900 antialiased font-sans leading-relaxed">
@php
    $statusClasses = [
        'paid' => 'bg-green-100 text-green-800',
        'unpaid' => 'bg-yellow-100 text-yellow-800',
        'overdue' => 'bg-red-100 text-red-800',
        'draft' => 'bg-gray-100 text-gray-800',
    ];
    $statusText = [
        'paid' => 'Betalt',
        'unpaid' => 'Ubetalt',
        'overdue' => 'Forfalden',
        'draft' => 'Kladde',
    ];
    $status = $invoice->status ?? 'draft'; // Default to 'draft' if status is not set
@endphp

    <!-- Status Banner -->
<div class="{{ $statusClasses[$status] }} py-3 text-center font-semibold">
    {{ $statusText[$status] }}
</div>

<div class="max-w-4xl mx-auto bg-white p-4 sm:p-8 rounded-xl shadow-xl mt-4">


    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center border-b-2 border-gray-200 pb-6 mb-6">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">Faktura</h1>

        </div>
        <div class="mt-4 sm:mt-0">
            <p class="text-sm text-gray-500">Faktura #: <span class="font-semibold text-gray-700">{{ $invoice->invoice_number ?? 'Draft' }}</span></p>
            <p class="text-sm text-gray-500">Dato: <span class="font-semibold text-gray-700">{{ $invoice->sent_at?->format('d/m/Y') }}</span></p>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-8">
        <div>
            <h2 class="text-lg font-semibold text-gray-700 mb-2">Modtager:</h2>
            <p class="text-gray-600">{{ $invoice->association?->name }}</p>
            <p class="text-gray-600">Kasserer: {{ $invoice->association?->treasurer?->name }}</p>
        </div>
        <div class="sm:text-right">
            <h2 class="text-lg font-semibold text-gray-700 mb-2">Afsender:</h2>
            <p class="text-gray-600">Dansk Speedcube Forening</p>
            <p class="text-gray-600">cvr: 32800874</p>
        </div>
    </div>

    <div class="mb-8">
        <!-- Traditional Table for Larger Screens -->
        <div class="hidden sm:block">
            <table class="min-w-full bg-white border-collapse">
                <thead>
                <tr class="bg-indigo-500 text-white">
                    <th class="text-left py-4 px-6 font-semibold">Beskrivelse</th>
                    <th class="text-right py-4 px-6 font-semibold">Antal</th>
                    <th class="text-right py-4 px-6 font-semibold">Stykpris</th>
                    <th class="text-right py-4 px-6 font-semibold">Total</th>
                </tr>
                </thead>
                <tbody>
                <!-- iterate over invoice lines -->
                @foreach($invoice->lines as $line)
                    <tr class="border-b">
                        <td class="py-4 px-6 text-gray-700">{{ $line->description }}</td>
                        <td class="text-right py-4 px-6 text-gray-700">{{ $line->quantity }}</td>
                        <td class="text-right py-4 px-6 text-gray-700">{{ number_format($line->unit_price, 2, ',', '.') }}</td>
                        <td class="text-right py-4 px-6 text-gray-700">{{ number_format($line->total_price, 2, ',', '.') }}</td>
                    </tr>
                @endforeach
                <!-- Add more rows as necessary -->
                </tbody>
            </table>
        </div>

        <!-- Card Layout for Mobile Devices -->
        <div class="sm:hidden space-y-4">
            <div class="bg-white p-4 rounded-lg shadow">
                @foreach($invoice->lines as $line)
                    <div class="flex justify-between">
                        <span class="font-semibold text-gray-700">Beskrivelse:</span>
                        <span class="text-gray-700">{{ $line->description }}</span>
                    </div>
                    <div class="flex justify-between mt-2">
                        <span class="font-semibold text-gray-700">Antal:</span>
                        <span class="text-gray-700">{{ $line->quantity }}</span>
                    </div>
                    <div class="flex justify-between mt-2">
                        <span class="font-semibold text-gray-700">Stykpris:</span>
                        <span class="text-gray-700">{{ number_format($line->unit_price, 2, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between mt-2">
                        <span class="font-semibold text-gray-700">Total:</span>
                        <span class="text-gray-700">{{ number_format($line->total_price, 2, ',', '.') }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center">
        <div class="w-full sm:w-1/2 bg-gray-50 p-4 rounded-lg shadow-sm">
            <h2 class="text-lg font-semibold text-gray-700">Betaling</h2>
            <p class="text-gray-600">Betingelser: Netto, 30 dage</p>
            <p class="text-gray-600">Overføres til DSF's bankkonto. </p>
            <p class="text-gray-600">Angiv venligst fakturanummer.</p>
            <p class="text-gray-600">Reg. nr.: <b>1726</b>. Konto: <b>0751450885</b>.</p>
        </div>
        <div class="text-right mt-4 sm:mt-0 bg-gray-50 p-4 rounded-lg shadow-md w-full sm:w-auto">
            <p class="text-2xl font-bold text-indigo-600">Total: {{ number_format($invoice->amount, 2, ',', '.') }}</p>
        </div>
    </div>

{{--    <div class="border-t mt-6 sm:mt-8 pt-6 bg-gray-50 rounded-lg shadow-sm">--}}
{{--        <p class="text-sm text-gray-500 text-center"></p>--}}
{{--    </div>--}}
</div>



<!-- Mark as Paid Button (Conditional) -->
@if($invoice->status === 'unpaid')
    @can('markAsPaid', $invoice)
        <div class="mb-4 mt-10 text-center">
            <form action="{{ route('invoices.markAsPaid', $invoice) }}" method="POST" onsubmit="return confirm('Are you sure you want to mark this invoice as paid?');">
                @csrf
                @method('PATCH')
                <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                    Mark as Paid
                </button>
            </form>
        </div>
    @endcan
@endif

</body>
</html>
