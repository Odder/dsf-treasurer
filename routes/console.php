<?php

use App\Jobs\StampInvoices;
use Illuminate\Support\Facades\Schedule;

Schedule::job(new StampInvoices())->dailyAt('11:00')->withoutOverlapping();
Schedule::job(new StampInvoices())->dailyAt('11:00')->withoutOverlapping();
Schedule::command('telescope:prune')->daily();
