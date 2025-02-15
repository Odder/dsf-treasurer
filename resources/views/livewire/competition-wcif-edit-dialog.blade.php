<x-mush.comp.dialog id="competitionWcifEditDialog" title="Edit WCIF Association" maxWidth="xl">
    <div class="grid space-y-6">
        <div>
            <label for="billingAssociationId" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Afregning:</label>
            <select wire:model="billingAssociationId" id="billingAssociationId"
                    class="bw-input peer bank_account_number placeholder-transparent dark:placeholder-transparent medium text-black">
                <option value="" class="dark:bg-gray-800">-- Select Association --</option>
                @foreach($associations as $association)
                    <option value="{{ $association->id }}" class="dark:bg-gray-800">{{ $association->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="organisingAssociationId" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Organisør:</label>
            <select wire:model="organisingAssociationId" id="organisingAssociationId"
                    class="bw-input peer bank_account_number placeholder-transparent dark:placeholder-transparent medium text-black">
                <option value="" class="dark:bg-gray-800">-- Select Association --</option>
                @foreach($associations as $association)
                    <option value="{{ $association->id }}" class="dark:bg-gray-800">{{ $association->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="flex justify-end mt-4">
            <x-bladewind::button type="button" color="gray"
                                 x-on:click="$dispatch('close-dialog', { id: 'competitionWcifEditDialog' })">
                Cancel
            </x-bladewind::button>
            <x-bladewind::button wire:click="updateAssociation" class="ml-2">
                Update
            </x-bladewind::button>
        </div>
    </div>
</x-mush.comp.dialog>
