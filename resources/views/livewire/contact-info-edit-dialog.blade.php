<x-mush.comp.dialog id="contactInfoEditDialog" title="Edit Contact Info" maxWidth="md">
    <div class="grid space-y-4">
        <x-mush.form.input id="name" label="Name" :value="$name"/>
        <x-mush.form.input id="email" label="Email" :value="$email"/>
        <x-mush.form.input id="address" label="Address" :value="$address"/>
        <x-mush.form.input id="wca_id" label="WCA ID" :value="$wca_id"/>

        <div class="flex justify-end mt-4">
            <x-bladewind::button type="button" color="gray"
                                 x-on:click="$dispatch('close-dialog', { id: 'contactInfoEditDialog' })">
                Cancel
            </x-bladewind::button>
            <x-bladewind::button wire:click="updateContactInfo" class="ml-2">
                Update
            </x-bladewind::button>
        </div>
    </div>
</x-mush.comp.dialog>
