<?php

namespace App\Livewire;

use App\Jobs\GenerateInvoice;
use App\Jobs\UpdateCompetitionWcif;
use App\Models\Competition;
use Illuminate\Support\Facades\Gate;
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
        $canEditWcif = Gate::allows('editWcif', $this->competition);

        return view('livewire.competition-details', [
            'competition' => $this->competition,
            'wcif' => $this->competition->wcif,
            'organisers' => $this->organisers,
            'events' => $this->events,
            'totalEvents' => $this->totalEvents,
            'canEditWcif' => $canEditWcif,
        ]);
    }

    public function refetchWcif(): void
    {
        UpdateCompetitionWcif::dispatchSync($this->competition, public: false);
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

    public function openWcifEditDialog(): void
    {
        if (! Gate::allows('editWcif', $this->competition)) {
            abort(403, 'Unauthorized. You are not authorized to edit this competition WCIF.');
        }
        $this->dispatch('open-dialog', id: 'competitionWcifEditDialog');
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
