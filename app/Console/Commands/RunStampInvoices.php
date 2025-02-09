<?php

namespace App\Console\Commands;

use App\Jobs\StampInvoices;
use Illuminate\Console\Command;

class RunStampInvoices extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:stamp-invoices';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Runs the StampInvoices job.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Dispatching StampInvoices job...');

        StampInvoices::dispatchSync();

        $this->info('StampInvoices job dispatched.');
    }
}
