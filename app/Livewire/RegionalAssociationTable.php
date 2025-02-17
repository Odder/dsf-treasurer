<?php

namespace App\Livewire;

use App\Models\RegionalAssociation;
use Livewire\Component;
use Livewire\WithPagination;

class RegionalAssociationTable extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    public int $perPage = 10;

    public function render()
    {
        return view('livewire.regional-association-table', [
            'regionalAssociations' => RegionalAssociation::with(['members', 'competitions'])->paginate($this->perPage),
        ]);
    }
}
