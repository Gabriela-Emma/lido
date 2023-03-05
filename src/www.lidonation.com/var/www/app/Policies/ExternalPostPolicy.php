<?php

namespace App\Policies;

use App\Enums\PermissionEnum;
use App\Mo\ExternalPost;
use App\Models\User;

class ExternalPostPolicy extends AppPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): mixed
    {
        return $user->hasAnyPermission([PermissionEnum::read_external_posts()->value]) || $this->canViewAny($user);
    }

    /**
     * Determine whether the user can view the model.
     *
     *
     * @throws \Exception
     */
    public function view(User $user, ExternalPost $externalPost): bool
    {
        return $user->hasAnyPermission([PermissionEnum::read_external_posts()->value]) || $this->canView($user, $insight);
    }

    /**
     * Determine whether the user can create models.
     *
     *
     * @throws \Exception
     */
    public function create(User $user): bool
    {
        return $user->hasAnyPermission([PermissionEnum::create_external_posts()->value]) || $this->canCreate($user);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function update(User $user, ExternalPost $externalPost)
    {
        return $user->hasAnyPermission([PermissionEnum::update_external_posts()->value]) || $this->canUpdateAny($user);
    }

    /**
     * Determine whether the user can delete the model.
     *
     *
     * @throws \Exception
     */
    public function delete(User $user, ExternalPost $externalPost): mixed
    {
        return $user->hasAnyPermission([PermissionEnum::delete_external_posts()->value]) || $this->canDeleteAny($user);
    }
}
