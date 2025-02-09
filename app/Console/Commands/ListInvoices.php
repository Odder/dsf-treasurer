<?php

namespace App\Console\Commands;

use App\Jobs\FetchCompetitions;
use App\Jobs\GenerateInvoice;
use App\Models\Competition;
use App\Models\Invoice;
use Illuminate\Console\Command;

class ListInvoices extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:list-invoices';

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
        FetchCompetitions::dispatchSync();

        foreach (Competition::all() as $competition) {
            $this->info($competition->name);
            $this->info($competition->wca_id);
            GenerateInvoice::dispatchSync($competition);
        }

        $invoices = Invoice::all();
        foreach ($invoices as $invoice) {
            $this->info($invoice->invoice_number);
        }
    }
}
