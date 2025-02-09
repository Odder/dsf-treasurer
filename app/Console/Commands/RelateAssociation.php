<?php

namespace App\Console\Commands;

use App\Models\Invoice;
use App\Models\RegionalAssociation;
use App\Services\Wca\Wcif;
use Illuminate\Console\Command;

class RelateAssociation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:invoice-association {invoiceId} {wcifId}';

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
        $invoice = Invoice::find($this->argument('invoiceId'));
        $association = RegionalAssociation::where('wcif_identifier', '=', $this->argument('wcifId'))->first();

        if (!$association) {
            $this->error('Association not found');
        }
        if (!$invoice) {
            $this->error('Invoice not found');
        }

        $wcif = Wcif::fromId($invoice->competition->wca_id);
        $wcif->addRegionalAssociation($association);
        $invoice->association()->associate($association);
        $invoice->save();
        $this->info("Invoice {$invoice->id} has been associated with association {$association->name}");
    }
}
