<?php

namespace App\Jobs;

use App\Models\Competition;
use App\Services\Wca\Competitions;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class FetchCompetitions implements ShouldQueue
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
        $wca = new Competitions();
        $year = 2024;
        $competitions = $wca->list(since: "{$year}-01-01", before: "{$year}-12-31");
        foreach(array_reverse($competitions) as $competition) {
            echo $competition['name'] . PHP_EOL;
            if (!Competition::where('wca_id', $competition['id'])->exists()) {
                Competition::create([
                    'wca_id' => $competition['id'],
                    'name' => $competition['name'],
                    'number_of_competitors' => 0,
                    'start_date' => $competition['start_date'],
                    'end_date' => $competition['end_date'],
                ]);
            }
        }
    }
}
