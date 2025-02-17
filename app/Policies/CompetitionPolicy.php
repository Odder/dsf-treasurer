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
        return $user->isDSFBoardMember();
    }
}
