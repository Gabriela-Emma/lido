<?php

namespace App\Policies;

use App\Enums\PermissionEnum;
use App\Models\Rating;
use App\Models\User;

class RatingPolicy extends AppPolicy
{
    /**
     * Determine whether the user can view any models.
     *
     *
     * @throws \Exception
     */
    public function viewAny(User $user): mixed
    {
        return $user->hasAnyPermission([PermissionEnum::read_ratings()->value]) || $this->canViewAny($user);
    }

    /**
     * Determine whether the user can view the model.
     *
     *
     * @throws \Exception
     */
    public function view(User $user, Rating $rating): bool
    {
        return $user->hasAnyPermission([PermissionEnum::read_ratings()->value]) || $this->canView($user, $rating);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasAnyPermission([PermissionEnum::create_ratings()->value]) || $this->canCreate($user);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Rating $rating): mixed
    {
        return $user->hasAnyPermission([PermissionEnum::update_ratings()->value]) || $this->canUpdateAny($user);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Rating $rating): mixed
    {
        return $user->hasAnyPermission([PermissionEnum::delete_ratings()->value]) || $this->canDeleteAny($user);
    }
}
