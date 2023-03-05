<?php

namespace App\Policies;

use App\Enums\PermissionEnum;
use App\Models\EveryEpoch;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class EveryEpochPolicy extends AppPolicy
{
    /**
     * Determine whether the user can view any models.
     *
     * @return Response|bool
     */
    public function viewAny(User $user)
    {
        return $user->hasAnyPermission([PermissionEnum::update_quizzes()->value]) ||
            $this->canViewAny($user);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @return Response|bool
     */
    public function view(User $user, EveryEpoch $everyEpoch)
    {
        return $user->hasAnyPermission([PermissionEnum::update_quizzes()->value]) ||
            $this->canView($user, $everyEpoch);
    }

    /**
     * Determine whether the user can create models.
     *
     * @return Response|bool
     */
    public function create(User $user)
    {
        return $user->hasAnyPermission([PermissionEnum::update_quizzes()->value]) || $this->canCreate($user);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @return Response|bool
     */
    public function update(User $user, EveryEpoch $everyEpoch)
    {
        return $user->hasAnyPermission([PermissionEnum::update_quizzes()->value]) ||
            $this->canUpdate($user);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @return Response|bool
     */
    public function delete(User $user, EveryEpoch $everyEpoch)
    {
        return $this->canDelete($user);
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @return bool
     */
    public function restore(User $user, EveryEpoch $everyEpoch)
    {
        return $user->hasAnyPermission([PermissionEnum::update_quizzes()->value]) || $this->canCreate($user);
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @return Response|bool
     */
    public function forceDelete(User $user, EveryEpoch $everyEpoch)
    {
        return $this->canDelete($user);
    }
}
