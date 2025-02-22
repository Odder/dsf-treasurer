<?php

namespace App\Livewire;

use App\Models\MembershipFeePayment;
use Livewire\Component;

class MembershipFeeLookup extends Component
{
    public string $wcaId = '';
    public $payments = [];
    public bool $isMembershipActive = false;
    public ?string $lastPaymentDate = null;
    public ?string $membershipExpiryDate = null;
    public float $totalMembershipFee = 0;
    public float $totalMembershipFeePast14Months = 0;

    public function search(): void
    {
        $this->payments = MembershipFeePayment::where('wca_id', $this->wcaId)
            ->with('competition')
            ->orderBy('payment_date', 'desc')
            ->get();

        $this->calculateMembershipStatus();
        $this->calculateTotalMembershipFee();
        $this->calculateTotalMembershipFeePast14Months();
    }

    private function calculateMembershipStatus(): void
    {
        $fourteenMonthsAgo = now()->subMonths(14);
        $lastPayment = $this->payments
            ->where('amount', '>', 0)
            ->where('payment_date', '>=', $fourteenMonthsAgo)
            ->first();

        $this->lastPaymentDate = $this->payments->where('amount', '>', 0)->first()?->payment_date?->format('d/m/Y');

        if ($lastPayment) {
            $this->isMembershipActive = true;
            $this->membershipExpiryDate = $lastPayment->payment_date->addMonths(14)->format('d/m/Y');
        } else {
            $this->isMembershipActive = false;
            $this->membershipExpiryDate = null;
        }
    }

    private function calculateTotalMembershipFee(): void
    {
        $this->totalMembershipFee = $this->payments->sum('amount');
    }

    private function calculateTotalMembershipFeePast14Months(): void
    {
        $fourteenMonthsAgo = now()->subMonths(14);
        $this->totalMembershipFeePast14Months = $this->payments
            ->where('payment_date', '>=', $fourteenMonthsAgo)
            ->sum('amount');
    }

    public function render()
    {
        return view('livewire.membership-fee-lookup');
    }
}
