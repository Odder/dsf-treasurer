<?php

namespace App\Livewire;

use App\Jobs\GenerateInvoice;
use App\Jobs\UpdateCompetitionWcif;
use App\Models\Competition;
use App\Services\Wca\Wcif;
use Livewire\Component;

class CompetitionDetails extends Component
{
    public Competition $competition;
    public $organisers;
    public $events;
    public $totalEvents;

    public function mount(Competition $competition)
    {
        $this->competition = $competition;
        $this->loadWcifData();
    }

    public function render()
    {
        return view('livewire.competition-details', [
            'competition' => $this->competition,
            'wcif' => $this->competition->wcif,
            'organisers' => $this->organisers,
            'events' => $this->events,
            'totalEvents' => $this->totalEvents,
        ]);
    }

    public function refetchWcif(): void
    {
        UpdateCompetitionWcif::dispatchSync($this->competition);
        session()->flash('message', 'WCIF data successfully updated.');
        $this->competition->refresh();
        $this->loadWcifData();
    }

    public function generateInvoice(): void
    {
        // Dispatch the GenerateInvoice job
        GenerateInvoice::dispatch($this->competition);
        session()->flash('message', 'Invoice generation job dispatched!');
        $this->loadWcifData();
        $this->render();
    }

    private function loadWcifData(): void
    {
        $this->wcif = $this->competition->wcif;

        if ($this->wcif && $this->wcif->raw) {
            $this->organisers = collect($this->wcif->raw['persons'])
                ->filter(function ($person) {
                    return isset($person['roles']) && in_array('organizer', $person['roles']);
                })
                ->map(function ($person) {
                    return collect([
                        'name' => data_get($person, 'name'),
                        'wcaId' => data_get($person, 'wcaId'),
                        'avatarUrl' => data_get($person, 'avatar.thumbUrl'),
                    ]);
                });
            $this->events = collect($this->wcif->raw['events'])->pluck('id');
            $this->totalEvents = count($this->events);
        } else {
            $this->organisers = collect([]);
            $this->events = collect([]);
            $this->totalEvents = 0;
        }
    }
}
