<?php

namespace App\Policies;

use App\Models\RegionalAssociation;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RegionalAssociationPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true; // Or any other logic you want here
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, RegionalAssociation $regionalAssociation): bool
    {
        return true; // Or any other logic you want here
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return false; // Only admins can create
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, RegionalAssociation $regionalAssociation): bool
    {
        return $user->isDSFBoardMember();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, RegionalAssociation $regionalAssociation): bool
    {
        return false; // Only admins can delete
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, RegionalAssociation $regionalAssociation): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, RegionalAssociation $regionalAssociation): bool
    {
        return false;
    }
}
