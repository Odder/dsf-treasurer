<?php

namespace App\Livewire;

use App\Models\RegionalAssociation;
use Livewire\Component;

class RegionalAssociationDetails extends Component
{
    public RegionalAssociation $regionalAssociation;

    public function mount(RegionalAssociation $regionalAssociation)
    {
        $this->regionalAssociation = $regionalAssociation;
    }

    public function render()
    {
        return view('livewire.regional-association-details', [
            'unpaidInvoices' => $this->regionalAssociation->unpaidInvoices()->forCurrentUser()->paginate(10),
            'paidInvoices' => $this->regionalAssociation->paidInvoices()->forCurrentUser()->paginate(10),
            'upcomingCompetitions' => $this->regionalAssociation->competitions()->where('start_date', '>', now())->get(),
            'chairman' => $this->regionalAssociation->chairman()->first(),
            'treasurer' => $this->regionalAssociation->treasurer()->first(),
            'viceChair' => $this->regionalAssociation->viceChair()->first(),
            'accountant' => $this->regionalAssociation->accountant()->first(),
        ]);
    }
}
