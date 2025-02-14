<?php

use App\Jobs\FetchCompetitions;
use App\Jobs\GeneratePastCompetitionInvoices;
use App\Jobs\StampInvoices;
use App\Jobs\UpdateFutureCompetitionsWcif;
use Illuminate\Support\Facades\Schedule;

Schedule::job(new FetchCompetitions())->dailyAt('08:00');
Schedule::job(new UpdateFutureCompetitionsWcif())->weekly();
Schedule::job(new GeneratePastCompetitionInvoices())->weeklyOn(3, '10:00');
Schedule::job(new StampInvoices())->dailyAt('11:00')->withoutOverlapping();
Schedule::command('telescope:prune')->daily();
