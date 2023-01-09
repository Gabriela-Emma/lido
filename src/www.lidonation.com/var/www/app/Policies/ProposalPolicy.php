<?php

namespace App\Policies;

use App\Enums\PermissionEnum;
use App\Models\Proposal;
use App\Models\User;

class ProposalPolicy extends AppPolicy
{
    /**
     * Determine whether the user can view any models.
     *
     * @param  User  $user
     * @return mixed
     */
    public function viewAny(User $user): mixed
    {
        return $user->hasAnyPermission([PermissionEnum::read_proposals()->value]) || $this->canViewAny($user);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  User  $user
     * @param  Proposal  $proposal
     * @return bool
     *
     * @throws \Exception
     */
    public function view(User $user, Proposal $proposal): bool
    {
        return $user->hasAnyPermission([PermissionEnum::create_proposals()->value]) || $this->canView($user, $proposal);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  User  $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return $user->hasAnyPermission([PermissionEnum::create_proposals()->value]) || $this->canCreate($user);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  User  $user
     * @param  Proposal  $proposal
     * @return mixed
     */
    public function update(User $user, Proposal $proposal): mixed
    {
        return $user->hasAnyPermission([PermissionEnum::update_proposals()->value]) ||
            $this->canUpdate($user);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  User  $user
     * @param  Proposal  $proposal
     * @return mixed
     */
    public function delete(User $user, Proposal $proposal): mixed
    {
        return $user->hasAnyPermission([PermissionEnum::delete_proposals()->value]);
    }
}
