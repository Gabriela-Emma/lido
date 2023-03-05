<?php

namespace App\Policies;

use App\Enums\PermissionEnum;
use App\Models\Definition;
use App\Models\User;

class DefinitionPolicy extends AppPolicy
{
    /**
     * Determine whether the user can view any models.
     *
     *
     * @throws \Exception
     */
    public function viewAny(User $user): bool
    {
        return $user->hasAnyPermission([PermissionEnum::read_definitions()->value]) || $this->canViewAny($user);
    }

    /**
     * Determine whether the user can view the model.
     *
     *
     * @throws \Exception
     */
    public function view(User $user, Definition $definition): bool
    {
        return $user->hasAnyPermission([PermissionEnum::read_definitions()->value]) || $this->canView($user, $definition);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasAnyPermission([PermissionEnum::create_definitions()->value]) || $this->canCreate($user);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Definition $definition): bool
    {
        return $user->hasAnyPermission([PermissionEnum::update_definitions()->value]) || $this->canUpdateAny($user);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Definition $definition): bool
    {
        return $user->hasAnyPermission([PermissionEnum::delete_definitions()->value]) || $this->canDeleteAny($user);
    }
}
