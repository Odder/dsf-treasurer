<?php

namespace App\Livewire;

use App\Models\Invoice;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class InvoiceDetails extends Component
{
    public Invoice $invoice;

    public function mount(Invoice $invoice)
    {
        $this->invoice = $invoice;

        if (!Gate::allows('view', $this->invoice)) {
            abort(403, 'Unauthorized. You are not authorized to view this invoice.');
        }
    }

    public function render()
    {
        return view('livewire.invoice-details', [
            'invoice' => $this->invoice,
        ]);
    }
}
