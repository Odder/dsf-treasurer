<?php

namespace App\Http\Controllers;

use App\Jobs\FetchCompetitions;
use App\Jobs\GenerateInvoice;
use App\Models\Competition;
use App\Services\Wca\Wcif;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Livewire\Livewire;

class CompetitionController extends Controller
{
    public function index()
    {
        $competitionTableHtml = Livewire::mount('competition-table');

        return view('competitions.index', [
            'competitionTableHtml' => $competitionTableHtml,
        ]);
    }

    public function show(Competition $competition)
    {
        return view('competitions.show', ['competition' => $competition]);
    }
}
