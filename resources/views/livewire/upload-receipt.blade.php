<x-slot:header>
    Opret udlæg
</x-slot:header>

<div>
    <x-mush.layout.container>
        <div></div>
        @if (session()->has('message'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4"
                 role="alert">
                <strong class="font-bold">Success!</strong>
                <span class="block sm:inline">{{ session('message') }}</span>
            </div>
        @endif
        <x-mush.comp.card title="Opret udlæg">
            <form wire:submit="save" class="p-4">
                @if (!$receiptFile)
                    <div class="mb-4">
                        <input type="file" wire:model="receiptFile">
                        @error('receiptFile') <span class="text-red-500">{{ $message }}</span> @enderror
                    </div>
                @endif

                <div class="{{  $receiptFile ? '' : 'hidden' }}">
                    <x-mush.grid cols="2">
                        <div>
                            <img src="{{ $receiptFile?->temporaryUrl() }}" alt="Forhåndsvisning"
                                 class="w-full rounded-lg shadow-md">
                        </div>
                        <x-mush.grid cols="2">
                            <div class="col-span-2">
                                <x-mush.form.input
                                    id="amount"
                                    label="Beløb"
                                    placeholder="13,00"
                                />
                                @error('amount') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-span-2">
                                <x-mush.form.input
                                    id="description"
                                    label="Beskrivelse"
                                    placeholder="Indtast beskrivelse..."
                                />
                                @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <x-mush.form.input
                                    id="bank_account_reg"
                                    label="Reg. nummer"
                                    placeholder="1234"
                                />
                                @error('bank_account_reg') <span
                                    class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <x-mush.form.input
                                    id="bank_account_number"
                                    label="Kontonummer"
                                    placeholder="0001234567"
                                />
                                @error('bank_account_number') <span
                                    class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label for="association_id" class="block text-gray-700 text-sm font-bold mb-2">Forening
                                    (valgfrit)</label>
                                <select wire:model.live="association_id" id="association_id"
                                        class="bw-input peer bank_account_number placeholder-transparent dark:placeholder-transparent medium text-black">
                                    <option value="" class="dark:bg-gray-800">-- Vælg forening --</option>
                                    @foreach($associations as $association)
                                        <option value="{{ $association->id }}"
                                                class="dark:bg-gray-800">{{ $association->name }}</option>
                                    @endforeach
                                </select>
                                @error('association_id') <span
                                    class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label for="competition_id" class="block text-gray-700 text-sm font-bold mb-2">Konkurrence
                                    (valgfrit)</label>
                                <select wire:model.live="competition_id" id="competition_id"
                                        class="bw-input peer bank_account_number placeholder-transparent dark:placeholder-transparent medium text-black">
                                    <option value="" class="dark:bg-gray-800">-- Vælg konkurrence --</option>
                                    @foreach($competitions as $competition)
                                        <option value="{{ $competition->id }}"
                                                class="dark:bg-gray-800">{{ $competition->name }}</option>
                                    @endforeach
                                </select>
                                @error('competition_id') <span
                                    class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                            <div class="text-right col-span-2">
                                <x-bladewind::button can_submit="true">
                                    Upload kvittering
                                </x-bladewind::button>
                            </div>
                        </x-mush.grid>
                    </x-mush.grid>
                </div>
            </form>
        </x-mush.comp.card>
    </x-mush.layout.container>
</div>
