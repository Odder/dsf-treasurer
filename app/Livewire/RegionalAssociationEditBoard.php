<?php

namespace App\Livewire;

use App\Enums\AssociationRole;
use App\Models\ContactInfo;
use App\Models\RegionalAssociation;
use Livewire\Component;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class RegionalAssociationEditBoard extends Component
{
    use AuthorizesRequests;

    public RegionalAssociation $regionalAssociation;
    public ?string $chairmanId = null;
    public ?string $treasurerId = null;
    public ?string $viceChairId = null;
    public ?string $accountantId = null;
    public array $memberIds = [];
    public array $alternateIds = [];

    public function mount(RegionalAssociation $regionalAssociation)
    {
        $this->authorize('update', $regionalAssociation);

        $this->regionalAssociation = $regionalAssociation;
        $this->chairmanId = $regionalAssociation->chairman()->first()?->id;
        $this->treasurerId = $regionalAssociation->treasurer()->first()?->id;
        $this->viceChairId = $regionalAssociation->viceChair()->first()?->id;
        $this->accountantId = $regionalAssociation->accountant()->first()?->id;
        $this->memberIds = $regionalAssociation->members()->wherePivot('role', AssociationRole::MEMBER)->pluck('contact_infos.id')->toArray();
        $this->alternateIds = $regionalAssociation->members()->wherePivot('role', AssociationRole::ALTERNATE)->pluck('contact_infos.id')->toArray();
    }

    public function updateBoard()
    {
        $this->authorize('update', $this->regionalAssociation);

        $boardMembers = [];

        if ($this->chairmanId) {
            $boardMembers[$this->chairmanId] = ['role' => AssociationRole::CHAIRMAN];
        }
        if ($this->treasurerId) {
            $boardMembers[$this->treasurerId] = ['role' => AssociationRole::TREASURER];
        }
        if ($this->viceChairId) {
            $boardMembers[$this->viceChairId] = ['role' => AssociationRole::VICE_CHAIR];
        }
        if ($this->accountantId) {
            $boardMembers[$this->accountantId] = ['role' => AssociationRole::ACCOUNTANT];
        }

        foreach ($this->memberIds as $memberId) {
            $boardMembers[$memberId] = ['role' => AssociationRole::MEMBER];
        }

        foreach ($this->alternateIds as $alternateId) {
            $boardMembers[$alternateId] = ['role' => AssociationRole::ALTERNATE];
        }

        $this->regionalAssociation->members()->sync($boardMembers);

        return redirect()->route('regional-associations.show', $this->regionalAssociation);
    }

    public function render()
    {
        return view('livewire.regional-association-edit-board', [
            'availableContacts' => ContactInfo::orderBy('name')->get(),
        ]);
    }
}
