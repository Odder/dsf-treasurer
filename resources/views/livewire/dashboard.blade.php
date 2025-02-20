@php use Carbon\Carbon; @endphp
<div>
    <x-slot:header>
        Dashboard
    </x-slot:header>

    <x-mush.layout.container>
        <div></div>

        <x-mush.grid cols="2">
            @if(auth()->user()->isMemberOfAssociation())
                <x-mush.comp.card title="Faktura Oversigt">
                    <div class="p-4">
                        <p>Antal åbne fakturaer: {{ $openInvoiceCount }}</p>
                        <p>Samlet beløb: {{ number_format($openInvoiceAmount, 2, ',', '.') }}</p>
                    </div>
                </x-mush.comp.card>

                <x-mush.comp.card title="Mine Foreninger">
                    <div class="p-4">
                        @if($associations && count($associations) > 0)
                            <ul>
                                @foreach($associations as $association)
                                    <li>
                                        <x-mush.link link="/regional-associations/{{ $association->id }}">
                                            {{ $association->name }}
                                            @php
                                                $role = $association->pivot->role;
                                                $roleName = match ($role) {
                                                    'chairman' => 'Formand',
                                                    'vice-chairman' => 'Næstformand',
                                                    'treasurer' => 'Kasserer',
                                                    'member' => 'Medlem',
                                                    'alternate' => 'Suppleant',
                                                    'accountant' => 'Revisor',
                                                    default => 'Ukendt',
                                                };
                                            @endphp
                                            ({{ $roleName }})
                                        </x-mush.link>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p>Ingen foreninger tilknyttet.</p>
                        @endif
                    </div>
                </x-mush.comp.card>
            @endif

            <x-mush.comp.card title="Kommende Konkurrencer">
                <div class="p-4">
                    @if(count($upcomingCompetitions) > 0)
                        <ul>
                            @foreach($upcomingCompetitions as $competition)
                                <li>
                                    <x-mush.link link="/competitions/{{ $competition->id }}">
                                        {{ $competition->name }}
                                        ({{ Carbon::parse($competition->start_date)->diffForHumans() }})
                                    </x-mush.link>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p>Ingen kommende konkurrencer fundet.</p>
                    @endif
                </div>
            </x-mush.comp.card>

            <x-mush.comp.card title="Mine Udlæg">
                <div class="p-4">
                    <p>Antal åbne udlæg: {{ $pendingReceiptsCount }}</p>
                    <p>Samlet beløb: {{ number_format($pendingReceiptsAmount, 2, ',', '.') }}</p>
                    <x-mush.link link="/me/receipts">Se mine udlæg</x-mush.link>
                </div>
            </x-mush.comp.card>
        </x-mush.grid>
    </x-mush.layout.container>
</div>
