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
            $contactInfo = ContactInfo::where('wca_id', $user->wca_id)->first();
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
        // Check if the user is associated with DSF
        $dsfAssociation = RegionalAssociation::where('wcif_identifier', 'DSF')->first();

        if ($dsfAssociation) {
            if ($dsfAssociation->treasurer->wca_id == $user->wca_id || $dsfAssociation->chairman->id == $user->wca_id) {
                return true;
            }
        }

        // Get the contact info record associated with the user's wca_id
        $contactInfo = ContactInfo::where('wca_id', $user->wca_id)->first();

        if (!$contactInfo) {
            return false;
        }

        // Get the regional association IDs where the user is a chairman or treasurer
        $regionalAssociationIds = collect([
            ...$contactInfo->chairmanAssociations()->pluck('id')->toArray(),
            ...$contactInfo->treasurerAssociations()->pluck('id')->toArray(),
        ])->unique()->toArray();

        // Check if the invoice's association ID is in the allowed IDs
        return in_array($invoice->association_id, $regionalAssociationIds);
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
