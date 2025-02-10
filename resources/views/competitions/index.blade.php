<x-app-layout>
    <x-slot name="header">
        Konkurrence-oversigt
    </x-slot>

    <x-main-container>
        {!! $competitionTableHtml !!}
    </x-main-container>
</x-app-layout>
