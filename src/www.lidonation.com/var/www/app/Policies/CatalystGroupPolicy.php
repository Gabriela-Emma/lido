<?php

namespace App\Policies;

use App\Enums\PermissionEnum;
use App\Models\CatalystGroup;
use App\Models\User;

class CatalystGroupPolicy extends AppPolicy
{
    /**
     * Determine whether the user can view any models.
     *
     *
     * @throws \Exception
     */
    public function viewAny(User $user): bool
    {
        return $user->hasAnyPermission([PermissionEnum::read_catalyst_groups()->value]) || $this->canViewAny($user);
    }

    /**
     * Determine whether the user can view the model.
     *
     *
     * @throws \Exception
     */
    public function view(User $user, CatalystGroup $CatalystGroup): bool
    {
        return $user->hasAnyPermission([PermissionEnum::read_catalyst_groups()->value]) || $this->canView($user, $CatalystGroup);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasAnyPermission([PermissionEnum::create_catalyst_groups()->value]) || $this->canCreate($user);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, CatalystGroup $CatalystGroup): bool
    {
        return $user->hasAnyPermission([PermissionEnum::update_catalyst_groups()->value]) || $this->canUpdateAny($user);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, CatalystGroup $CatalystGroup): bool
    {
        return $user->hasAnyPermission([PermissionEnum::delete_catalyst_groups()->value]) || $this->canDeleteAny($user);
    }
}
