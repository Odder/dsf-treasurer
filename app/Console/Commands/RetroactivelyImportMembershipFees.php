<?php

namespace App\Console\Commands;

use App\Models\Invoice;
use App\Models\MembershipFeePayment;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class RetroactivelyImportMembershipFees extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-membership-fees';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Imports membership fees from competitions with existing invoices, using WCIF data to determine waivers.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $invoices = Invoice::with('competition')->get();

        foreach ($invoices as $invoice) {
            $competition = $invoice->competition;

            if (MembershipFeePayment::where('competition_id', $competition->id)->exists()) {
                $this->info("Skipping {$competition->name} (WCA ID: {$competition->wca_id}) - Membership fees already imported.");
                continue;
            }

            $wcif = $competition->wcif;

            if (!$wcif || !collect($wcif->raw)->get('persons')) {
                $this->info("Skipping {$competition->name} (WCA ID: {$competition->wca_id}) - No WCIF data.");
                continue;
            }

            $participants = $wcif->getCompetitors();
            $nonPayingParticipants = $participants->filter(fn($c) => $c['roles'] && (in_array('organizer', $c['roles']) || in_array('delegate', $c['roles'])));

            foreach ($participants as $participant) {
                $wcaId = $participant['wcaId'];
                $isWaived = $nonPayingParticipants->contains(function ($nonPayingParticipant) use ($wcaId) {
                    return $nonPayingParticipant['wcaId'] === $wcaId;
                });

                $amount = $isWaived ? 0 : 25;

                try {
                    MembershipFeePayment::create([
                        'wca_id' => $wcaId,
                        'competition_id' => $competition->id,
                        'amount' => $amount,
                        'waived' => $isWaived,
                        'payment_date' => $competition->start_date,
                    ]);
                } catch (\Exception $e) {
                    Log::error("Failed to create MembershipFeePayment for {$participant['name']} in {$competition->name}: " . $e->getMessage());
                    $this->error("Failed to create MembershipFeePayment for {$participant['name']} in {$competition->name}. See log for details.");
                }
            }

            $this->info("Imported membership fees for {$competition->name} (WCA ID: {$competition->wca_id}).");
        }

        $this->info('Membership fee import complete.');
    }
}
