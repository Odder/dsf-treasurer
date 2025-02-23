<div>
    <x-slot:header>
        Søg efter Kontingent Betalinger
    </x-slot:header>

    <x-mush.layout.container>
        <div></div>

        <x-mush.comp.card title="Søg efter WCA ID">
            <div class="p-4">
                <div class="mb-4">
                    <x-mush.form.input
                        id="wcaId"
                        label="WCA ID"
                        placeholder="Indtast WCA ID"
                        change="naiveSearch"
                    />
                </div>
            </div>
        </x-mush.comp.card>

        @if (count($payments) > 0)
            <x-mush.grid cols="2">
                <x-mush.comp.card title="Medlemsskab">
                    <div class="p-4">
                        @php
                            $level = $isMembershipActive ? 'success' : 'danger';
                            $statusText = $isMembershipActive ? 'Aktivt' : 'Inaktivt';
                        @endphp
                        <div>Medlemsskab: <x-mush.comp.badge :level="$level" :text="$statusText" /></div>
                        <div>Medlemsskab udløber: {{ $membershipExpiryDate ?? 'medlemskab er ikke aktivt' }}</div>

                    </div>
                </x-mush.comp.card>

                <x-mush.comp.card title="Kontigent">
                    <div class="p-4">
                        <div>Seneste kontingent: {{ $lastPaymentDate ?? 'Ingen betalinger fundet' }}</div>
                        <div>Kontigent seneste 14
                            måneder: {{ number_format($totalMembershipFeePast14Months, 2, ',', '.') }}</div>
                        <div>Totalt kontigent: {{ number_format($totalMembershipFee, 2, ',', '.') }}</div>
                    </div>
                </x-mush.comp.card>
            </x-mush.grid>
            <x-mush.comp.card title="Kontingent Betalinger">
                <x-mush.comp.table>
                    <x-slot:header>
                        <x-mush.comp.table-th>Konkurrence</x-mush.comp.table-th>
                        <x-mush.comp.table-th>Beløb</x-mush.comp.table-th>
                        <x-mush.comp.table-th>Fritaget</x-mush.comp.table-th>
                        <x-mush.comp.table-th>Dato</x-mush.comp.table-th>
                    </x-slot:header>

                    <x-slot:body>
                        @foreach ($payments as $payment)
                            <x-mush.comp.table-tr wire:key="{{ $payment->id }}">
                                <x-mush.comp.table-td>
                                    @if($payment->competition)
                                        <x-mush.link link="/competitions/{{ $payment->competition->id }}">
                                            {{ $payment->competition->name }}
                                        </x-mush.link>
                                    @else
                                        Manuel betaling
                                    @endif
                                </x-mush.comp.table-td>
                                <x-mush.comp.table-td class="text-right">{{ $payment->amount > 1 ? number_format($payment->amount, 2) : '-' }}</x-mush.comp.table-td>
                                <x-mush.comp.table-td>{{ $payment->waived ? 'Ja' : 'Nej' }}</x-mush.comp.table-td>
                                <x-mush.comp.table-td>{{ $payment->payment_date->format('d/m/Y') }}</x-mush.comp.table-td>
                            </x-mush.comp.table-tr>
                        @endforeach
                    </x-slot:body>
                </x-mush.comp.table>
            </x-mush.comp.card>
        @elseif (!empty($wcaId))
            <x-mush.comp.card>
                <div class="p-4">Ingen betalinger fundet for WCA ID: {{ $wcaId }}</div>
            </x-mush.comp.card>
        @endif
    </x-mush.layout.container>
</div>
