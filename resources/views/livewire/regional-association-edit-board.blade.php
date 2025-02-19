<div>
    <x-slot:header>
        Ændr Bestyrelse for: {{ $regionalAssociation->name }}
    </x-slot:header>

    <x-mush.layout.container>
        <div></div>

        <x-mush.comp.card title="Opdater bestyrelse">
            <form wire:submit.prevent="updateBoard" class="p-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <x-mush.form.select
                            id="chairmanId"
                            label="Formand"
                            :items="$availableContacts->pluck('name', 'id')"
                            default="-- Vælg Formand --"
                        />
                    </div>

                    <div>
                        <x-mush.form.select
                            id="viceChairId"
                            label="Næstformand"
                            :items="$availableContacts->pluck('name', 'id')"
                            default="-- Vælg Næstformand --"
                        />
                    </div>

                    <div>
                        <x-mush.form.select
                            id="treasurerId"
                            label="Kasserer"
                            :items="$availableContacts->pluck('name', 'id')"
                            default="-- Vælg Kasserer --"
                        />
                    </div>

                    <div>
                        <x-mush.form.select
                            id="accountantId"
                            label="Revisor"
                            :items="$availableContacts->pluck('name', 'id')"
                            default="-- Vælg Revisor --"
                        />
                    </div>
                </div>

                <div class="mt-6">
                    <x-bladewind::button can_submit="true">Opdater</x-bladewind::button>
                </div>
            </form>
        </x-mush.comp.card>
    </x-mush.layout.container>
</div>
