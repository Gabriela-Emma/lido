<?php

namespace App\Policies;

use App\Enums\PermissionEnum;
use App\Models\CatalystUser;
use App\Models\User;

class CatalystUserPolicy extends AppPolicy
{
    /**
     * Determine whether the user can view any models.
     *
     *
     * @throws \Exception
     */
    public function viewAny(User $user): mixed
    {
        return $user->hasAnyPermission([PermissionEnum::read_links()->value]) || $this->canViewAny($user);
    }

    /**
     * Determine whether the user can view the model.
     *
     *
     * @throws \Exception
     */
    public function view(User $user, CatalystUser $catalystUser): bool
    {
        return $user->hasAnyPermission([PermissionEnum::read_links()->value]) || $this->canView($user, $catalystUser);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasAnyPermission([PermissionEnum::create_links()->value]) || $this->canCreate($user);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, CatalystUser $catalystUser): mixed
    {
        return $user->hasAnyPermission([PermissionEnum::update_links()->value]) || $this->canUpdateAny($user);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, CatalystUser $catalystUser): mixed
    {
        return $user->hasAnyPermission([PermissionEnum::delete_links()->value]) || $this->canDeleteAny($user);
    }
}
