<?php

namespace App\Policies;

use App\Enums\PermissionEnum;
use App\Models\Tag;
use App\Models\User;

class TagPolicy extends AppPolicy
{
    /**
     * Determine whether the user can view any models.
     *
     *
     * @throws \Exception
     */
    public function viewAny(User $user): mixed
    {
        return $user->hasAnyPermission([PermissionEnum::read_tags()->value]) || $this->canViewAny($user);
    }

    /**
     * Determine whether the user can view the model.
     *
     *
     * @throws \Exception
     */
    public function view(User $user, Tag $tag): bool
    {
        return $user->hasAnyPermission([PermissionEnum::read_tags()->value]) || $this->canView($user, $tag);
    }

    /**
     * Determine whether the user can create models.
     *
     *
     * @throws \Exception
     */
    public function create(User $user): bool
    {
        return $user->hasAnyPermission([PermissionEnum::create_tags()->value]) || $this->canCreate($user);
    }

    /**
     * Determine whether the user can update the model.
     *
     *
     * @throws \Exception
     */
    public function update(User $user, Tag $tag): mixed
    {
        return $user->hasAnyPermission([PermissionEnum::update_tags()->value]) || $this->canUpdateAny($user);
    }

    /**
     * Determine whether the user can delete the model.
     *
     *
     * @throws \Exception
     */
    public function delete(User $user, Tag $tag): mixed
    {
        return $user->hasAnyPermission([PermissionEnum::delete_tags()->value]) || $this->canDeleteAny($user);
    }
}
