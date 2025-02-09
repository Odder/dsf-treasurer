<?php

namespace App\Console\Commands;

use App\Jobs\FetchCompetitions;
use App\Jobs\GenerateInvoice;
use App\Models\Competition;
use App\Models\Invoice;
use App\Services\Wca\Competitions;
use App\Services\Wca\Wcif;
use Illuminate\Console\Command;
use Spatie\LaravelPdf\Facades\Pdf;

class InvoiceStatistics extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:invoice-stats';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        foreach (Competition::all() as $competition) {
            $this->info($competition->name);
        }
        $this->info(2024);
        $invoices2024 = Invoice::byYear(2024)->with('competition')->with('association')->get(['id', 'name', 'participants', 'amount', 'status', 'competition_id', 'association_id']);
        $invoices = $invoices2024->map(function ($invoice) {
            return [
                'id' => $invoice->id,
                'status' => $invoice->status,
                'name' => $invoice->competition->name,
                'participants' => $invoice->participants,
                'amount' => $invoice->amount,
                'association' => $invoice?->association?->name,
            ];
        });
        $invoicesByAssociation = $invoices2024->groupBy('association')->map(function ($invoices) {
            return [
                'association' => $invoices->pluck('association')->first()?->name,
                'number_of_participants' => $invoices->sum('participants'),
                'amount' => $invoices->sum('amount'),
            ];
        });
        $this->table(['id', 'status', 'Competition', 'participants', 'amount', 'association'], $invoices);
        $this->table(['Year', 'Participants', 'Amount'], [[2024, $invoices2024->sum('participants'), $invoices2024->sum('amount')]]);
        $this->table(['Association', 'Participants', 'Amount'], $invoicesByAssociation);
    }
}
