<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AppPolicy
{
    use HandlesAuthorization;

    /**
     * Perform pre-authorization checks.
     *
     * @param  \App\Models\User  $user
     * @param  string  $ability
     * @return void|bool
     */
    public function before(User $user, $ability)
    {
        if ($user->hasAnyRole(['admin', 'super_admin', 'super admin'])) {
            return true;
        }
    }

    /**
     * Determine whether the user can view any models.
     *
     * @param  User  $user
     * @return mixed
     */
    public function canViewAny(User $user)
    {
        return $user->hasAnyRole(['admin', 'super_admin', 'super admin']);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  User  $user
     * @return mixed
     *
     * @throws \Exception
     */
    public function canView(User $user, $model): mixed
    {
        return $user->hasAnyRole(['admin', 'super_admin', 'super admin']);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  User  $user
     * @return bool
     */
    public function canCreate(User $user): bool
    {
        return $user->hasAnyRole(['admin', 'super_admin', 'super admin']);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  User  $user
     * @return mixed
     */
    public function canUpdate(User $user)
    {
        return $user->hasAnyRole(['admin', 'super_admin', 'super admin']);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  User  $user
     * @return mixed
     */
    public function canUpdateAny(User $user)
    {
        return $user->hasAnyRole(['admin', 'super_admin', 'super admin']);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  User  $user
     * @return mixed
     */
    public function canDelete(User $user)
    {
        return $user->hasAnyRole(['admin', 'super_admin', 'super admin']);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  User  $user
     * @return mixed
     */
    public function canDeleteAny(User $user)
    {
        return $user->hasAnyRole(['admin', 'super_admin', 'super admin']);
    }
}
