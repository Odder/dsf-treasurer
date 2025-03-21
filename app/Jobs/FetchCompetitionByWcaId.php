<?php

namespace App\Jobs;

use App\Models\Competition;
use App\Services\Wca\Facades\Wcif;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Spatie\DiscordAlerts\Facades\DiscordAlert;

class FetchCompetitionByWcaId implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @param  string  $wcaId
     */
    public function __construct(public string $wcaId)
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $wcif = Wcif::fromId($this->wcaId);

            if (!$wcif) {
                $message = "❌ Failed to fetch WCIF for: **{$this->wcaId}**";
                Log::error($message);
                DiscordAlert::message($message);
                return;
            }

            $competitionData = $wcif->raw;

            if (!Competition::where('wca_id', $competitionData['id'])->exists()) {
                $startDate = Carbon::parse($competitionData['schedule']['startDate']);
                $numberOfDays = $competitionData['schedule']['numberOfDays'];
                $endDate = $startDate->copy()->addDays($numberOfDays - 1);

                $competition = Competition::create([
                    'wca_id' => $competitionData['id'],
                    'name' => $competitionData['name'],
                    'number_of_competitors' => 0,
                    'start_date' => $startDate,
                    'end_date' => $endDate,
                ]);

                $message = "🎉 New competition found: **{$competition->name}** (WCA ID: {$competition->wca_id})";
                DiscordAlert::message($message);
                Log::info($message);
            } else {
                Log::info("Competition {$competitionData['name']} already exists.");
            }

        } catch (\Exception $e) {
            Log::error("Job FetchCompetitionByWcaId failed for wca_id {$this->wcaId}: " . $e->getMessage() . "\n" . $e->getTraceAsString());
            DiscordAlert::message("🔥 Job failed for: **{$this->wcaId}**: " . $e->getMessage());
            $this->fail($e);
        }
    }
}
