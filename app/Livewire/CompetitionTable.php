<?php

namespace App\Livewire;

use App\Models\Competition;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class CompetitionTable extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    public int $perPage = 10;

    public function render()
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        return view('livewire.competition-table', [
            'competitions' => Competition::orderBy('start_date', 'desc')->paginate($this->perPage),
        ]);
    }
}
