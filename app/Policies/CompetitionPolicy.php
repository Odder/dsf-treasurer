<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Competition;
use App\Models\RegionalAssociation;

class CompetitionPolicy
{
    /**
     * Determine whether the user can edit the WCIF data.
     */
    public function editWcif(User $user, Competition $competition): bool
    {
        $dsfAssociation = RegionalAssociation::where('wcif_identifier', 'DSF')->first();

        if ($dsfAssociation) {
            return ($dsfAssociation->treasurer?->wca_id == $user->wca_id || $dsfAssociation->chairman?->wca_id == $user->wca_id);
        }

        return false;
    }
}
