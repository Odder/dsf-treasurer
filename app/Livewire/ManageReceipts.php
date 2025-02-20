<?php

namespace App\Livewire;

use App\Enums\ReceiptStatus;
use App\Models\Receipt;
use App\Models\RegionalAssociation;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class ManageReceipts extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    public int $perPage = 10;
    public $status;

    public function mount()
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        $dsfAssociation = RegionalAssociation::where('wcif_identifier', 'DSF')->first();

        if (!Auth::user()->isMemberOfAssociation($dsfAssociation)) {
            abort(403, 'Unauthorized.');
        }
    }

    public function render()
    {
        $receivedReceipts = Receipt::with(['association', 'competition'])->where('status', ReceiptStatus::REPORTED)->paginate($this->perPage, pageName: 'receivedReceiptsPage');
        $acceptedReceipts = Receipt::with(['association', 'competition'])->where('status', ReceiptStatus::ACCEPTED)->paginate($this->perPage, pageName: 'acceptedReceiptsPage');
        $closedReceipts = Receipt::with(['association', 'competition'])->whereIn('status', [ReceiptStatus::REJECTED, ReceiptStatus::SETTLED])->paginate($this->perPage, pageName: 'closedReceiptsPage');
        return view('livewire.manage-receipts', [
            'receivedReceipts' => $receivedReceipts,
            'acceptedReceipts' => $acceptedReceipts,
            'closedReceipts' => $closedReceipts,
        ]);
    }

    public function updateStatus(Receipt $receipt, string $status)
    {
        $receipt->update(['status' => ReceiptStatus::from($status)]);
        $this->resetPage();
    }

    public function getAvailableStatuses(): array
    {
        return [
            ReceiptStatus::REPORTED->value => 'Indsendt',
            ReceiptStatus::ACCEPTED->value => 'Godkend',
            ReceiptStatus::REJECTED->value => 'Afvis',
            ReceiptStatus::SETTLED->value => 'Afgør',
        ];
    }
}
