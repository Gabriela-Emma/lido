<?php

namespace App\Policies;

use App\Enums\PermissionEnum;
use App\Models\Discussion;
use App\Models\User;

class DiscussionPolicy extends AppPolicy
{
    /**
     * Determine whether the user can view any models.
     *
     * @param  User  $user
     * @return bool
     *
     * @throws \Exception
     */
    public function viewAny(User $user): bool
    {
        return $user->hasAnyPermission([
            PermissionEnum::create_discussions()->value,
        ]) || $this->canViewAny($user);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  User  $user
     * @param  Discussion  $discussion
     * @return bool
     *
     * @throws \Exception
     */
    public function view(User $user, Discussion $discussion): bool
    {
        return $user->hasAnyPermission([
            PermissionEnum::create_discussions()->value,
        ]) || $this->canView($user, $discussion);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  User  $user
     * @return bool
     *
     * @throws \Exception
     */
    public function create(User $user): bool
    {
        return $user->hasAnyPermission([
            PermissionEnum::create_discussions()->value,
        ]) || $this->canCreate($user);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  User  $user
     * @param  Discussion  $discussion
     * @return bool
     *
     * @throws \Exception
     */
    public function update(User $user, Discussion $discussion): bool
    {
        return $user->hasAnyPermission([
            PermissionEnum::update_discussions()->value,
        ]) || $this->canUpdateAny($user);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  User  $user
     * @param  Discussion  $discussion
     * @return bool
     *
     * @throws \Exception
     */
    public function delete(User $user, Discussion $discussion): bool
    {
        return $user->hasAnyPermission([
            PermissionEnum::delete_discussions()->value,
        ]) || $this->canDeleteAny($user);
    }
}
