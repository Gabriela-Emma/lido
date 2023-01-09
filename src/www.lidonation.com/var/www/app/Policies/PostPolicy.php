<?php

namespace App\Policies;

use App\Enums\PermissionEnum;
use App\Models\Post;
use App\Models\User;

class PostPolicy extends AppPolicy
{
    /**
     * Determine whether the user can view any models.
     *
     * @param  User  $user
     * @return mixed
     */
    public function viewAny(User $user): mixed
    {
        return $user->hasAnyPermission([PermissionEnum::read_posts()->value]) || $this->canViewAny($user);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  User  $user
     * @param  Post  $post
     * @return bool
     */
    public function view(User $user, Post $post): bool
    {
        return $user->hasAnyPermission([PermissionEnum::read_posts()->value]) || $this->canView($user, $post);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  User  $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return $user->hasAnyPermission([PermissionEnum::create_posts()->value]) || $this->canCreate($user);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  User  $user
     * @param  Post  $post
     * @return mixed
     */
    public function update(User $user, Post $post)
    {
        return $user->hasAnyPermission([PermissionEnum::update_posts()->value]) || $this->canUpdateAny($user);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  User  $user
     * @param  Post  $post
     * @return mixed
     */
    public function delete(User $user, Post $post)
    {
        return $user->hasAnyPermission([PermissionEnum::delete_posts()->value]) || $this->canDeleteAny($user);
    }
}
