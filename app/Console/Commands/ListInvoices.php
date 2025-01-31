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
        // dispatch Fetch Competitions job
        FetchCompetitions::dispatchSync();

        foreach (Competition::all() as $competition) {

            $this->info($competition->name);
            $this->info($competition->wca_id);
        }
        GenerateInvoice::dispatchSync(Competition::where('wca_id', 'AllesammenSammeniRoskilde2024')->first());

        $invoices = Invoice::all();
        foreach ($invoices as $invoice) {
            $this->info($invoice->invoice_number);
        }

        exit();

        // list all competitions wca
        $wca = new Competitions();
        foreach ($wca->list() as $wcaCompetition) {
            $this->info($wcaCompetition['name']);
            $wcif = new Wcif($wca->getWcif($wcaCompetition['id']));
            foreach ($wcif->getCompetitors() as $competitor) {
                $this->info($competitor['name']);
            }
            exit();
        }
    }
}
