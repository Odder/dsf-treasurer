<x-slot name="header">
    Opret udlæg
</x-slot>

<div>
    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <strong class="font-bold">Success!</strong>
            <span class="block sm:inline">{{ session('message') }}</span>
        </div>
    @endif
    <x-main-container>
        <form wire:submit="save" class="p-4">
            @if (!$receiptFile)
                <div class="mb-4">
                    <label for="image" class="block text-gray-700 text-sm font-bold mb-2">Billede af kvittering:</label>
                    <input type="file" wire:model="receiptFile">
                    @error('receiptFile') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 {{  $receiptFile ? '' : 'hidden' }}">
                <div>
                    <img src="{{ $receiptFile?->temporaryUrl() }}" alt="Forhåndsvisning"
                         class="w-full rounded-lg shadow-md">
                </div>
                <div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="col-span-2">
                            <h2>
                                Detaljer
                            </h2>
                        </div>
                        <div class="col-span-2">
                            <x-bladewind::input
                                type="number"
                                name="amount"
                                label="Beløb"
                                wire:model="amount"
                                step="0.01" {{-- Allows decimal input --}}
                            />
                            @error('amount') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-span-2">
                            <x-bladewind::textarea name="description" label="Beskrivelse" wire:model="description"/>
                            @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <x-bladewind::input name="bank_account_reg" label="Reg. til udbetaling"
                                                wire:model="bank_account_reg"/>
                            @error('bank_account_reg') <span
                                class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <x-bladewind::input name="bank_account_number" label="Kontonummer til udbetaling"
                                                wire:model="bank_account_number"/>
                            @error('bank_account_number') <span
                                class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="association_id" class="block text-gray-700 text-sm font-bold mb-2">Forening (valgfrit)</label>
                            <select wire:model.live="association_id" id="association_id"  class="bw-input peer bank_account_number placeholder-transparent dark:placeholder-transparent medium text-black">
                                <option value="" class="dark:bg-gray-800">-- Vælg forening --</option>
                                @foreach($associations as $association)
                                    <option value="{{ $association->id }}" class="dark:bg-gray-800">{{ $association->name }}</option>
                                @endforeach
                            </select>
                            @error('association_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="competition_id" class="block text-gray-700 text-sm font-bold mb-2">Forening (valgfrit)</label>
                            <select wire:model.live="competition_id" id="competition_id"  class="bw-input peer bank_account_number placeholder-transparent dark:placeholder-transparent medium">
                                <option value="" class="dark:bg-gray-800">-- Vælg forening --</option>
                                @foreach($competitions as $competition)
                                    <option value="{{ $competition->id }}">{{ $competition->name }}</option>
                                @endforeach
                            </select>
                            @error('competition_id') <span class="dark:bg-gray-800">{{ $message }}</span> @enderror
                        </div>
                        <div class="text-right col-span-2">
                            <x-bladewind::button can_submit="true">
                                Upload kvittering
                            </x-bladewind::button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </x-main-container>
</div>
