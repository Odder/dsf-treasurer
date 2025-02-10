<?php

namespace App\Livewire;

use App\Models\Invoice;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use Livewire\WithPagination;

class InvoiceTable extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    public int $perPage = 10;

    public function render()
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        if (Gate::allows('viewAny', Invoice::class)) {
            $invoices = Invoice::with('association')->paginate($this->perPage);
        } else {
            $invoices = Invoice::forCurrentUser()->with('association')->paginate($this->perPage);
        }

        return view('livewire.invoice-table', [
            'invoices' => $invoices,
        ]);
    }
}
