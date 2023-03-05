<?php

namespace App\Policies;

use App\Enums\PermissionEnum;
use App\Models\User;
use Spatie\Permission\Models\Permission;

class PermissionPolicy extends AppPolicy
{
    /**
     * Determine whether the user can view any models.
     *
     *
     * @throws \Exception
     */
    public function viewAny(User $user): mixed
    {
        return $user->hasAnyPermission([PermissionEnum::read_permissions()->value]) || $this->canViewAny($user);
    }

    /**
     * Determine whether the user can view the model.
     *
     *
     * @throws \Exception
     */
    public function view(User $user, Permission $permission): bool
    {
        return $user->hasAnyPermission([PermissionEnum::read_permissions()->value]) || $this->canView($user, $permission);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasAnyPermission([PermissionEnum::create_permissions()->value]) || $this->canCreate($user);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Permission $permission): mixed
    {
        return $user->hasAnyPermission([PermissionEnum::update_permissions()->value]) || $this->canUpdateAny($user);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Permission $permission): mixed
    {
        return $user->hasAnyPermission([PermissionEnum::delete_permissions()->value]) || $this->canDeleteAny($user);
    }
}
