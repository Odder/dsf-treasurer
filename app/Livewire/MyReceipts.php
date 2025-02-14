<?php

namespace App\Livewire;

use App\Models\Receipt;
use Livewire\Component;

class MyReceipts extends Component
{
    public $receipts;

    public function mount()
    {
        $this->receipts = Receipt::with(['association', 'competition'])->where('user_id', auth()->id())->get();
    }

    public function render()
    {
        return view('livewire.my-receipts');
    }

    public function updateStatus(Receipt $receipt, $status) {
        $receipt->update(['status' => $status]);
        $this->mount();
    }
}
