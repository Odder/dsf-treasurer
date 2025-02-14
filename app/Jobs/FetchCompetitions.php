<?php

namespace App\Jobs;

use App\Models\Competition;
use App\Services\Wca\Competitions;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Spatie\DiscordAlerts\Facades\DiscordAlert;

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
        $year = 2025;
        $competitions = $wca->list(since: "{$year}-01-01", before: "{$year}-12-31");

        if (!$competitions) {
            Log::error("Failed to fetch competitions from WCA API.");
            DiscordAlert::message("❌ Failed to fetch competitions from WCA API.");
            return;
        }

        foreach (array_reverse($competitions) as $competitionData) {
            if (!Competition::where('wca_id', $competitionData['id'])->exists()) {
                $competition = Competition::create([
                    'wca_id' => $competitionData['id'],
                    'name' => $competitionData['name'],
                    'number_of_competitors' => 0,
                    'start_date' => $competitionData['start_date'],
                    'end_date' => $competitionData['end_date'],
                ]);

                $message = "🎉 New competition found: **{$competition->name}** (WCA ID: {$competition->wca_id})";
                DiscordAlert::message($message);
                Log::info($message);
            } else {
                Log::info("Competition {$competitionData['name']} already exists.");
            }
        }
    }
}
