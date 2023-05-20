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
     */
    public function canViewAny(User $user): mixed
    {
        return $user->hasAnyRole(['admin', 'super_admin', 'super admin']);
    }

    /**
     * Determine whether the user can view the model.
     *
     *
     * @throws \Exception
     */
    public function canView(User $user, $model): mixed
    {
        return $user->hasAnyRole(['admin', 'super_admin', 'super admin']) || $this->ownsModel($user, $model);
    }

    /**
     * Determine whether the user can create models.
     */
    public function canCreate(User $user): bool
    {
        return $user->hasAnyRole(['admin', 'super_admin', 'super admin']);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function canUpdate(User $user, $model): mixed
    {
        return $user->hasAnyRole(['admin', 'super_admin', 'super admin']) || $this->ownsModel($user, $model);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @return mixed
     */
    public function canUpdateAny(User $user)
    {
        return $user->hasAnyRole(['admin', 'super_admin', 'super admin']);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @return mixed
     */
    public function canDelete(User $user, $model)
    {
        return $user->hasAnyRole(['admin', 'super_admin', 'super admin']) || $this->ownsModel($user, $model);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @return mixed
     */
    public function canDeleteAny(User $user)
    {
        return $user->hasAnyRole(['admin', 'super_admin', 'super admin']);
    }

    protected function ownsModel(User $user, $model): bool
    {
        return $user->id === $model->user_id;
    }
}
