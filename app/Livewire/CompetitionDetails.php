<?php

namespace App\Livewire;

use App\Models\Competition;
use App\Services\Wca\Wcif;
use Livewire\Component;

class CompetitionDetails extends Component
{
    public Competition $competition;
    public $wcif;
    public $competitors;
    public $events;

    public function mount(Competition $competition)
    {
        $this->competition = $competition;
        // $this->loadWcifData();
    }

    public function loadWcifData()
    {
        $this->wcif = Wcif::fromId($this->competition->wca_id);

        if (!$this->wcif) {
            $this->addError('wcif', 'WCIF data not found for this competition.');
            return;
        }

        $this->competitors = collect($this->wcif->raw['persons'])->map(function ($person) {
            return collect([
                'name' => $person['name'],
                'wcaId' => $person['wcaId'],
                'roles' => $person['roles'],
                'country' => $person['countryIso2'],
                'registration' => $person['registration'],
            ]);
        });

        $this->events = collect($this->wcif->raw['events'])->pluck('id')->toArray();
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
        $this->loadWcifData();
    }

    public function generateInvoice()
    {
        // Dispatch the GenerateInvoice job
        \App\Jobs\GenerateInvoice::dispatch($this->competition);
        session()->flash('message', 'Invoice generation job dispatched!');
    }
}
