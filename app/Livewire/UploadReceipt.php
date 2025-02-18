<?php

namespace App\Livewire;

use App\Models\Competition;
use App\Models\Receipt;
use App\Models\RegionalAssociation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class UploadReceipt extends Component
{
    use WithFileUploads;

    #[Validate('required')]
    public $receiptFile;
    #[Validate('numeric|min:0')] // Validate that the amount is numeric and non-negative
    public ?float $amount = null;
    public string $description;
    public ?string $bank_account_reg = null;
    public ?string $bank_account_number = null;
    public ?string $association_id = null;
    public ?string $competition_id = null;
    public $associations;
    public $competitions;
    public function mount()
    {
        $this->associations = RegionalAssociation::all();
        $this->competitions = Competition::all();
    }

    public function save()
    {
        $this->validate();

        $path = Storage::disk('s3')->putFile('/receipts', $this->receiptFile);

        Receipt::create([
            'user_id' => Auth::id(),
            'association_id' => $this->association_id,
            'competition_id' => $this->competition_id,
            'image_path' => $path,
            'description' => $this->description,
            'amount' => $this->amount,
            'bank_account_reg' => $this->bank_account_reg,
            'bank_account_number' => $this->bank_account_number,
        ]);

        session()->flash('message', 'Receipt uploaded successfully.');

        $this->reset(['receiptFile', 'amount', 'description', 'bank_account_reg', 'bank_account_number', 'association_id', 'competition_id']);
    }

    public function render()
    {
        return view('livewire.upload-receipt');
    }
}
