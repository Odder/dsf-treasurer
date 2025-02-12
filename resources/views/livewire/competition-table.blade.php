@php
    use Carbon\Carbon;
@endphp

<x-slot name="header">
    Konkurrence-oversigt
</x-slot>

<x-main-container>
    <x-bladewind::table
        layout="custom"
        divided="thin"
        :data="$competitions->items()">
        <x-slot:header>
            <th>Navn</th>
            <th>Forening</th>
            <th>Deltagere</th>
            <th>Dato</th>
            <th>Faktura</th>
        </x-slot:header>

        <tbody>
        @forelse($competitions as $competition)
            <tr wire:key="{{ $competition->id }}" class="dark:bg-gray-700">
                <td>
                    <a href="/competitions/{{ $competition->id }}" wire:navigate.hover>
                        <div>{{ $competition->name }}</div>
                    </a>
                </td>

                <td>
                    @if($competition->invoices->first())
                        <a href="/regional-associations/{{ $competition->invoices->first()->association->id }}" wire:navigate.hover>
                            <div>{{ $competition->invoices->first()->association->name }}</div>
                        </a>
                    @endif
                </td>
                <td>
                    <div>{{ $competition->invoices->first()?->participants }}</div>
                </td>
                <td>
                    <div>{{ Carbon::parse($competition->start_date)->format('d/m/Y') }}</div>
                </td>
                <td>
                    <a href="/invoices/{{ $competition->invoices->first()?->id }}" wire:navigate.hover>
                        <div>{{ $competition->invoices->first()?->invoice_number }}</div>
                    </a>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6">
                    <div class="text-sm text-white-500">Ingen konkurrencer fundet.</div>
                </td>
            </tr>
        @endforelse
        </tbody>
    </x-bladewind::table>
    <div class="px-4 py-3 bg-white dark:bg-gray-800 border-t border-gray-500 ">
        {{ $competitions->links() }}
    </div>
</x-main-container>
