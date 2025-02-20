<?php

namespace App\Livewire;

use App\Enums\ReceiptStatus;
use App\Models\Competition;
use App\Models\Invoice;
use App\Models\Receipt;
use App\Models\RegionalAssociation;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Dashboard extends Component
{
    public $openInvoiceCount = 0;
    public $openInvoiceAmount = 0;
    public $associations = [];
    public $upcomingCompetitions = [];
    public $pendingReceiptsCount = 0;
    public $pendingReceiptsAmount = 0;

    public function mount()
    {
        $user = Auth::user();

        if ($user->isMemberOfAssociation()) {
            $this->openInvoiceCount = Invoice::where('status', 'unpaid')->count();
            $this->openInvoiceAmount = Invoice::where('status', 'unpaid')->sum('amount');
            $this->associations = $user->contact?->associations()->withPivot('role')->get();
        }

        $this->upcomingCompetitions = Competition::where('start_date', '>=', now()->toDateString())
            ->orderBy('start_date')
            ->limit(5)
            ->get();

        $this->pendingReceiptsCount = Receipt::where('user_id', auth()->id())->whereIn('status', [ReceiptStatus::REPORTED, ReceiptStatus::ACCEPTED])->count();
        $this->pendingReceiptsAmount = Receipt::where('user_id', auth()->id())->whereIn('status', [ReceiptStatus::REPORTED, ReceiptStatus::ACCEPTED])->sum('amount');
    }

    public function render()
    {
        return view('livewire.dashboard');
    }
}
