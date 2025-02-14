<?php

namespace App\Jobs;

use App\Models\Competition;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Bus;

class GeneratePastCompetitionInvoices implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $competitions = Competition::where('end_date', '<', now())->get();
        foreach ($competitions as $competition) {
            if (!$competition->invoices()->exists()) {
                Bus::chain([
                    new UpdateCompetitionWcif($competition),
                    new GenerateInvoice($competition),
                ])->dispatch();
            }
        }
    }
}
