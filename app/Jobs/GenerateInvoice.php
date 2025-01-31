<?php

namespace App\Jobs;

use App\Models\Competition;
use App\Services\Wca\Competitions;
use App\Services\Wca\Wcif;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class GenerateInvoice implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(public Competition $competition)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $wcif = Wcif::fromId($this->competition->wca_id);

        if (!$this->competition->invoices()->exists()) {
            $this->competition->invoices()->create([
                'participants' => $wcif->getCompetitors()->count(),
                'non_paying_participants' => $wcif->getCompetitors()->filter(fn($c) => $c['roles'] && in_array('organizer', $c['roles']))->count(),
                'amount' => $wcif->getCompetitors()->count() * 20,
            ]);
        }
    }
}
