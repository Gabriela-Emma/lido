<?php

namespace App\Policies;

use App\Enums\PermissionEnum;
use App\Models\Assessment;
use App\Models\Comment;
use App\Models\User;

class CommentPolicy extends AppPolicy
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
        return $user->hasAnyPermission([PermissionEnum::read_comments()->value]) || $this->canViewAny($user);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  User  $user
     * @param  Assessment|Comment  $comment
     * @return bool
     *
     * @throws \Exception
     */
    public function view(User $user, Assessment|Comment $comment): bool
    {
        return $user->hasAnyPermission([PermissionEnum::read_comments()->value]) || $this->canView($user, $comment);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  User  $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return $user->hasAnyPermission([PermissionEnum::create_comments()->value]) || $this->canCreate($user);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  User  $user
     * @param  Assessment|Comment  $comment
     * @return mixed
     */
    public function update(User $user, Assessment|Comment $comment): mixed
    {
        return $user->hasAnyPermission([PermissionEnum::update_comments()->value]) || $this->canUpdateAny($user);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  User  $user
     * @param  Assessment|Comment  $comment
     * @return mixed
     */
    public function delete(User $user, Assessment|Comment $comment): mixed
    {
        return $user->hasAnyPermission([PermissionEnum::delete_comments()->value]) || $this->canDeleteAny($user);
    }
}
