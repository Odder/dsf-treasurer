<?php

namespace App\Jobs;

use App\Models\Competition;
use App\Models\Invoice;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class StampInvoices implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
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
        $date = Carbon::now()->subDays(3)->toDateString();

        $competitions = Competition::where('end_date', '<=', $date)->get();

        foreach ($competitions as $competition) {
            $invoices = $competition->invoices()->whereNull('invoice_number')->get();

            foreach ($invoices as $invoice) {
                try {
                    $invoice->stamp();
                    Log::info("Stamped invoice {$invoice->id} for competition {$competition->name}");
                } catch (\Exception $e) {
                    Log::error("Failed to stamp invoice {$invoice->id} for competition {$competition->name}: " . $e->getMessage());
                }
            }
        }
    }
}
