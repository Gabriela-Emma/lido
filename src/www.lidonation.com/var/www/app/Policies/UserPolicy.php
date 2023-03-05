<?php

namespace App\Policies;

use App\Enums\PermissionEnum;
use App\Models\User;
use Illuminate\Foundation\Auth\User as Authenticatable;

class UserPolicy extends AppPolicy
{
    /**
     * Determine whether the user can view any models.
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function viewAny(User $user)
    {
        return $user->hasAnyPermission([PermissionEnum::read_users()->value]) || $this->canViewAny($user);
    }

    /**
     * Determine whether the user can view the model.
     *
     *
     * @throws \Exception
     */
    public function view(User $user, Authenticatable $model): mixed
    {
        return $user->hasAnyPermission([PermissionEnum::read_users()->value]) ||
            $this->canView($user, $model);
    }

    /**
     * Determine whether the user can create models.
     *
     *
     * @throws \Exception
     */
    public function create(User $user): bool
    {
        return $user->hasAnyPermission([PermissionEnum::create_users()->value]) || $this->canCreate($user);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function update(User $user, Authenticatable $model)
    {
        return $user->hasAnyPermission([PermissionEnum::update_users()->value]) || $this->canUpdateAny($user);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function delete(User $user, Authenticatable $model)
    {
        return $user->hasAnyPermission([PermissionEnum::delete_users()->value]) || $this->canDeleteAny($user);
    }
}
