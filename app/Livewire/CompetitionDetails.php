<?php

namespace App\Livewire;

use App\Jobs\UpdateCompetitionWcif;
use App\Models\Competition;
use App\Services\Wca\Wcif;
use Livewire\Component;

class CompetitionDetails extends Component
{
    public Competition $competition;
    public $wcif;
    public $competitors;
    public $events;
    public $updatingWcif = false;

    public function mount(Competition $competition)
    {
        $this->competition = $competition;
    }

    public function render()
    {
        return view('livewire.competition-details', [
            'competition' => $this->competition,
            'wcif' => $this->wcif,
            'competitors' => $this->competitors,
            'events' => $this->events,
        ]);
    }

    public function refetchWcif()
    {
        $this->updatingWcif = false;
        UpdateCompetitionWcif::dispatchSync($this->competition);
        session()->flash('message', 'WCIF data successfully updated.');
        $this->updatingWcif = false;
    }

    public function generateInvoice()
    {
        // Dispatch the GenerateInvoice job
        \App\Jobs\GenerateInvoice::dispatch($this->competition);
        session()->flash('message', 'Invoice generation job dispatched!');
    }
}
