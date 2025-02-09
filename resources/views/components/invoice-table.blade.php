@props(['invoices'])

<div class="overflow-x-auto rounded-lg shadow-md">
    <table class="min-w-full divide-y divide-white-200 dark:divide-white-700">
        <thead class="bg-white-50 dark:bg-white-800">
        <tr>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white-500 uppercase tracking-wider">
                #
            </th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white-500 uppercase tracking-wider">
                Status
            </th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white-500 uppercase tracking-wider">
                Konkurrence
            </th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white-500 uppercase tracking-wider">
                Forening
            </th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white-500 uppercase tracking-wider">
                Total
            </th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white-500 uppercase tracking-wider">
                Forfaldsdato
            </th>
        </tr>
        </thead>
        <tbody class="bg-white divide-y divide-white-200 dark:bg-white-900 dark:divide-white-700">
        @forelse($invoices as $invoice)
            <tr>
                <td class="px-6 py-4 whitespace-nowrap">
                    <a href="/invoices/{{ $invoice->id }}" class="text-sm text-blue-600 dark:text-blue-400 hover:underline">
                        {{ $invoice->invoice_number }}
                    </a>
                </td>

                <td class="px-6 py-4 whitespace-nowrap">
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
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-{{ $statusColor }}-100 text-{{ $statusColor }}-800">
                        {{ $statusText }}
                    </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm text-white-900 dark:text-white-200">{{ $invoice->competition?->name }}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm text-white-900 dark:text-white-200">{{ $invoice->association?->name }}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm text-white-900 dark:text-white-200">{{ $invoice->amount }}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm text-white-900 dark:text-white-200">{{ \Carbon\Carbon::parse($invoice->due_at)->format('d/m/Y') }}</div>
                </td>
            </tr>
        @empty
            <tr>
                <td class="px-6 py-4 whitespace-nowrap text-center" colspan="6">
                    <div class="text-sm text-white-500">Ingen fakturaer fundet.</div>
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div>
