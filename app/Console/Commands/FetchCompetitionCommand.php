<?php

namespace App\Console\Commands;

use App\Jobs\FetchCompetitionByWcaId;
use Illuminate\Console\Command;

class FetchCompetitionCommand extends Command
{
    protected $signature = 'app:fetch-competition {wca_id}';  // Added argument

    protected $description = 'Fetches a competition from the WCA API by WCA ID';

    public function handle()
    {
        $wcaId = $this->argument('wca_id'); // Get the argument

        $this->info("Fetching competition with WCA ID: {$wcaId}");

        FetchCompetitionByWcaId::dispatchSync($wcaId);

        $this->info("Job dispatched to fetch competition {$wcaId}. Check the queue for progress.");
    }
}
