<?php

namespace App\Jobs;

use App\Models\Competition;
use App\Services\Wca\Wcif;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateCompetitionWcif implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(private readonly Competition $competition)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $wcif = Wcif::fromId($this->competition->wca_id);
        $this->competition->update(['wcif' => $wcif->raw]);
    }
}
