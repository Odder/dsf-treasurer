<?php

namespace App\Jobs;

use App\Models\Competition;
use App\Models\InvoiceLine;
use App\Models\RegionalAssociation;
use App\Services\Wca\Competitions;
use App\Services\Wca\Wcif;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Spatie\DiscordAlerts\Facades\DiscordAlert;

class GenerateInvoice implements ShouldQueue
{
    use Queueable;
    use InteractsWithQueue; // Required for failed() method

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
        $competitionName = $this->competition->name;
        $wcaId = $this->competition->wca_id;

        DiscordAlert::message("⚙️ Generating invoice for: **{$competitionName}** (WCA ID: {$wcaId})");

        try {
            if (!$this->competition->invoices()->exists()) {
                $wcif = Wcif::fromId($this->competition->wca_id);
                if (!$wcif) {
                    $message = "❌ Failed to fetch WCIF for: **{$competitionName}**";
                    Log::error($message);
                    DiscordAlert::message($message);
                    return;
                }
                $regionalAssociation = RegionalAssociation::where('wcif_identifier', '=', $wcif->getRegionalAssociation())->first();
                $participants = $wcif->getCompetitors()->count();
                $nonPayingParticipants = $wcif->getCompetitors()->filter(fn($c) => $c['roles'] && (in_array('organizer', $c['roles']) || in_array('delegate', $c['roles'])))->count();
                $invoice = $this->competition->invoices()->create([
                    'participants' => $participants,
                    'amount' => 25 * ($participants- $nonPayingParticipants),
                    'non_paying_participants' => $nonPayingParticipants,
                    'association_id' => $regionalAssociation?->id,
                ]);

                $invoice->lines()->createMany([
                    [
                        'description' => "Kontigent for deltagere til {$competitionName}",
                        'quantity' => $invoice->participants,
                        'unit_price' => 25,
                        'total_price' => 25 * $participants,
                    ],
                    [
                        'description' => "Deltagere fritaget for kontigent",
                        'quantity' => $invoice->non_paying_participants,
                        'unit_price' => -25,
                        'total_price' => -25 * $nonPayingParticipants,
                    ],
                ]);
                DiscordAlert::message("✅ Invoice generated for: **{$competitionName}** (Invoice Number: {$invoice->invoice_number})");
            } else {
                DiscordAlert::message("ℹ️ Invoice already exists for: **{$competitionName}**. Skipping.");
            }
        } catch (\Exception $e) {
            Log::error("Job GenerateInvoice failed for competition {$this->competition->name}: " . $e->getMessage() . "\n" . $e->getTraceAsString());
            DiscordAlert::message("🔥 Job failed for: **{$competitionName}**: " . $e->getMessage());
            throw $e; // Important: Re-throw the exception to mark the job as failed in the queue
        }
    }

    /**
     * The job failed to process.
     *
     * @param  \Throwable  $exception
     * @return void
     */
    public function failed(\Throwable $exception): void
    {
        $competitionName = $this->competition->name;
        DiscordAlert::message("🚨🚨🚨 **{$competitionName}** invoice generation failed permanently! " . $exception->getMessage());
    }
}
