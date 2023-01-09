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
     * @param  User  $user
     * @return mixed
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
     * @param  User  $user
     * @param  Rating  $rating
     * @return bool
     *
     * @throws \Exception
     */
    public function view(User $user, Rating $rating): bool
    {
        return $user->hasAnyPermission([PermissionEnum::read_ratings()->value]) || $this->canView($user, $rating);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  User  $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return $user->hasAnyPermission([PermissionEnum::create_ratings()->value]) || $this->canCreate($user);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  User  $user
     * @param  Rating  $rating
     * @return mixed
     */
    public function update(User $user, Rating $rating): mixed
    {
        return $user->hasAnyPermission([PermissionEnum::update_ratings()->value]) || $this->canUpdateAny($user);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  User  $user
     * @param  Rating  $rating
     * @return mixed
     */
    public function delete(User $user, Rating $rating): mixed
    {
        return $user->hasAnyPermission([PermissionEnum::delete_ratings()->value]) || $this->canDeleteAny($user);
    }
}
