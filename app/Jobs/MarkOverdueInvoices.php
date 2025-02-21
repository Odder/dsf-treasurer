<?php

namespace App\Jobs;

use App\Models\Invoice;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Spatie\DiscordAlerts\Facades\DiscordAlert;

class MarkOverdueInvoices implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle()
    {
        $overdueInvoices = Invoice::pastDueAt()->unpaid()->get();

        $count = 0;

        foreach ($overdueInvoices as $invoice) {
            $invoice->status = 'overdue';
            $invoice->save();
            $count++;

            $message = "⏰ Invoice **{$invoice->invoice_number}** for **{$invoice->competition->name}** is now overdue!  Amount: {$invoice->amount}";
            DiscordAlert::message($message);
            Log::info($message);
        }

        Log::info("Marked {$count} invoices as overdue via job.");
    }
}
