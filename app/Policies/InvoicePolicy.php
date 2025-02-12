<?php

namespace App\Policies;

use App\Models\ContactInfo;
use App\Models\Invoice;
use App\Models\User;
use App\Models\RegionalAssociation; // Import the RegionalAssociation model

class InvoicePolicy
{
    /**
     * Determine whether the user can view any invoices.
     */
    public function viewAny(User $user): bool
    {
        // Check if the user is associated with DSF
        $dsfAssociation = RegionalAssociation::where('wcif_identifier', 'DSF')->first();

        if ($dsfAssociation) {
            if ($dsfAssociation->treasurer->wca_id == $user->wca_id || $dsfAssociation->chairman->id == $user->wca_id) {
                return true;
            }
        }
        return false;
    }

    /**
     * Determine whether the user can view the invoice.
     */
    public function view(User $user, Invoice $invoice): bool
    {
        return $invoice->scopeForCurrentUser(Invoice::query())->where('id', $invoice->id)->exists();
    }

    /**
     * Determine whether the user can mark the invoice as paid.
     */
    public function markAsPaid(User $user, Invoice $invoice): bool
    {
        $dsfAssociation = RegionalAssociation::where('wcif_identifier', 'DSF')->first();

        if ($dsfAssociation) {
            if ($dsfAssociation->treasurer->wca_id == $user->wca_id || $dsfAssociation->chairman->id == $user->wca_id) {
                return true;
            }
        }

        return false;
    }

    /**
     * Determine whether the user can create invoices.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the invoice.
     */
    public function update(User $user, Invoice $invoice): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the invoice.
     */
    public function delete(User $user, Invoice $invoice): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the invoice.
     */
    public function restore(User $user, Invoice $invoice): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the invoice.
     */
    public function forceDelete(User $user, Invoice $invoice): bool
    {
        return false;
    }
}
