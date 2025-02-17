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
            'unpaidInvoices' => $this->regionalAssociation->unpaidInvoices()->forCurrentUser()->get(),
            'paidInvoices' => $this->regionalAssociation->paidInvoices()->forCurrentUser()->get(),
            'upcomingCompetitions' => $this->regionalAssociation->competitions()->where('start_date', '>', now())->get(),
            'chairman' => $this->regionalAssociation->chairman()->first(),
            'treasurer' => $this->regionalAssociation->treasurer()->first(),
        ]);
    }
}
