<?php

namespace App\Policies;

use App\Enums\PermissionEnum;
use App\Models\User;
use Spatie\Permission\Models\Role;

class RolePolicy extends AppPolicy
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
        return $user->hasAnyRole([PermissionEnum::read_roles()->value]) || $this->canViewAny($user);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  User  $user
     * @return bool
     *
     * @throws \Exception
     */
    public function view(User $user, Role $role): bool
    {
        return $user->hasAnyRole([PermissionEnum::read_roles()->value]) || $this->canView($user, $role);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  User  $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return $user->hasAnyRole([PermissionEnum::create_roles()->value]) || $this->canCreate($user);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  User  $user
     * @param  Role  $role
     * @return mixed
     */
    public function update(User $user, Role $role): mixed
    {
        return $user->hasAnyRole([PermissionEnum::update_roles()->value]) || $this->canUpdateAny($user);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  User  $user
     * @param  Role  $role
     * @return mixed
     */
    public function delete(User $user, Role $role): mixed
    {
        return $user->hasAnyRole([PermissionEnum::delete_roles()->value]) || $this->canDeleteAny($user);
    }
}
