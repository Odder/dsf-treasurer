<x-mush.comp.dialog id="contactInfoCreateDialog" title="Create Contact Info" maxWidth="md">
    <div class="grid space-y-4">
        <x-mush.form.input id="name" label="Name" wire:model="name" placeholder="John Doe"/>
        <x-mush.form.input id="email" label="Email" wire:model="email" placeholder="john.doe@example.com"/>
        <x-mush.form.input id="address" label="Address" wire:model="address" placeholder="123 Main St"/>
        <x-mush.form.input id="wca_id" label="WCA ID" wire:model="wca_id" placeholder="2008ANDE02"/>

        <div class="flex justify-end mt-4">
            <x-bladewind::button type="button" color="gray"
                                 x-on:click="$dispatch('close-dialog', { id: 'contactInfoCreateDialog' })">
                Cancel
            </x-bladewind::button>
            <x-bladewind::button wire:click="createContactInfo" class="ml-2">
                Create
            </x-bladewind::button>
        </div>
    </div>
</x-mush.comp.dialog>
