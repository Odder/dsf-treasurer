<?php

namespace App\Livewire;

use App\Models\Competition;
use App\Models\Invoice;
use App\Models\RegionalAssociation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use Livewire\WithPagination;

class InvoiceTable extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    public ?string $statusFilter = null;
    public ?string $associationFilter = null;

    public int $perPage = 15;

    public function render()
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        $query = Invoice::forCurrentUser()->with('association', 'competition');

        if ($this->statusFilter) {
            $query->where('status', $this->statusFilter);
        }

        if ($this->associationFilter) {
            $query->where('association_id', $this->associationFilter);
        }

        $invoices = $query->orderBy('id', 'desc')->paginate($this->perPage);

        return view('livewire.invoice-table', [
            'invoices' => $invoices,
            'associations' => RegionalAssociation::all(),
            'competitions' => Competition::all(),
        ]);
    }

    public function updating()
    {
        $this->resetPage();
    }
}
