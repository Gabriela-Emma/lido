<?php

namespace App\Policies;

use App\Enums\PermissionEnum;
use App\Models\User;
use App\Models\Vote;

class VotePolicy extends AppPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): mixed
    {
        return $user->hasAnyPermission([PermissionEnum::read_votes()->value]) ||
            $this->canViewAny($user);
    }

    /**
     * Determine whether the user can view the model.
     *
     *
     * @throws \Exception
     */
    public function view(User $user, Vote $vote): bool
    {
        return $user->hasAnyPermission([PermissionEnum::read_votes()->value]) ||
            $this->canView($user, $vote) ||
            $vote->user_id === $user->id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasAnyPermission([PermissionEnum::create_votes()->value]) || $this->canCreate($user);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Vote $vote): mixed
    {
        return $user->hasAnyPermission([PermissionEnum::update_votes()->value]) ||
            $this->canUpdate($user) ||
            $vote->user_id === $user->id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Vote $vote): mixed
    {
        return $user->hasAnyPermission([PermissionEnum::delete_votes()->value]) ||
        $this->canUpdate($user) ||
        $vote->user_id === $user->id;
    }
}
