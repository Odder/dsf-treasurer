<?php

namespace App\Livewire;

use App\Models\Competition;
use App\Models\RegionalAssociation;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class CompetitionWcifEditDialog extends Component
{
    public Competition $competition;
    public ?string $organisingAssociationId = null;
    public ?string $billingAssociationId = null;
    public $organisingAssociation = null;
    public $billingAssociation = null;
    public $test;
    public $associations;

    public function mount(Competition $competition)
    {
        if (! Gate::allows('editWcif', $competition)) {
            abort(403, 'Unauthorized. You are not authorized to edit this competition WCIF.');
        }

        $this->competition = $competition;
        $this->associations = RegionalAssociation::all();
        $this->billingAssociationId = RegionalAssociation::where('wcif_identifier', '=', $competition->wcif->getBillingAssociation())->first()?->id;
        $this->organisingAssociationId = RegionalAssociation::where('wcif_identifier', '=', $competition->wcif->getOrganisingAssociation())->first()?->id;
    }

    public function updateAssociation()
    {
        $this->competition->wcif->addRegionalAssociation(
            RegionalAssociation::find($this->billingAssociationId),
            RegionalAssociation::find($this->organisingAssociationId),
        );
        $this->dispatch('close-dialog', id: 'competitionWcifEditDialog');
    }

    public function render()
    {
        return view('livewire.competition-wcif-edit-dialog');
    }
}
