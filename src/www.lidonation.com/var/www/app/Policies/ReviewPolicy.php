<?php

namespace App\Policies;

use App\Enums\PermissionEnum;
use App\Models\Review;
use App\Models\User;

class ReviewPolicy extends AppPolicy
{
    /**
     * Determine whether the user can view any models.
     *
     * @param  User  $user
     * @return mixed
     */
    public function viewAny(User $user): mixed
    {
        return $user->hasAnyPermission([PermissionEnum::read_reviews()->value]) || $this->canViewAny($user);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  User  $user
     * @param  Review  $review
     * @return bool
     *
     * @throws \Exception
     */
    public function view(User $user, Review $review): bool
    {
        return $user->hasAnyPermission([PermissionEnum::read_reviews()->value]) || $this->canView($user, $review);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  User  $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return $user->hasAnyPermission([PermissionEnum::create_reviews()->value]) || $this->canCreate($user);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  User  $user
     * @param  Review  $review
     * @return mixed
     */
    public function update(User $user, Review $review)
    {
        return $user->hasAnyPermission([PermissionEnum::update_reviews()->value]) || $this->canUpdateAny($user);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  User  $user
     * @param  Review  $review
     * @return mixed
     */
    public function delete(User $user, Review $review)
    {
        return $user->hasAnyPermission([PermissionEnum::delete_reviews()->value]) || $this->canDeleteAny($user);
    }
}
