@php
    $statusClasses = [
        'reported' => 'bg-gray-100 text-gray-800',
        'accepted' => 'bg-green-100 text-green-800',
        'rejected' => 'bg-red-100 text-red-800',
        'settled' => 'bg-blue-100 text-blue-800',
    ];
    $statusText = [
        'reported' => 'Indsendt',
        'accepted' => 'Godkendt',
        'rejected' => 'Afvist',
        'settled' => 'Afregnet',
    ];
@endphp

<x-slot name="header">
    Mine udlæg
</x-slot>

<x-main-container>
    <x-bladewind::table
        layout="custom"
        divided="thin"
        :data="$receipts"
    >
        <x-slot:header>
            <th>Kvittering</th>
            <th>Beløb</th>
            <th>Beskrivelse</th>
            <th>Forening</th>
            <th>Konkurrence</th>
            <th>Status</th>
            <th>Actions</th>
        </x-slot:header>

        <tbody>
        @forelse ($receipts as $receipt)
            <tr wire:key="{{ $receipt->id }}" class="dark:bg-gray-700">
                <td>
                    <a href="{{ asset('storage/' . $receipt->image_path) }}" target="_blank">
                        <img src="{{ asset('storage/' . $receipt->image_path) }}" alt="Receipt" style="max-width: 100px;">
                    </a>
                </td>
                <td>{{ number_format($receipt->amount, 2, ',', '.') }}</td>
                <td>{{ $receipt->description }}</td>
                <td>
                    @if ($receipt->association)
                        <a href="/regional-associations/{{ $receipt->association->id }}" wire:navigate.hover>
                            {{ $receipt->association->name }}
                        </a>
                    @else
                        -
                    @endif
                </td>
                <td>
                    @if ($receipt->competition)
                        <a href="/competitions/{{ $receipt->competition->id }}" wire:navigate.hover>
                            {{ $receipt->competition->name }}
                        </a>
                    @else
                        -
                    @endif
                </td>
                <td>
                    @php
                        $status = $receipt->status;
                    @endphp
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClasses[$status] }}">
                        {{ $statusText[$status] }}
                    </span>
                </td>
                <td>
                    @if($receipt->status == 'reported' || $receipt->status == 'accepted')
                        <x-bladewind::button wire:click="updateStatus('{{$receipt->id}}', 'rejected')" size="tiny" color="red">Annulér</x-bladewind::button>
                    @endif
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7">Ingen udlæg fundet.</td>
            </tr>
        @endforelse
        </tbody>
    </x-bladewind::table>
</x-main-container>
