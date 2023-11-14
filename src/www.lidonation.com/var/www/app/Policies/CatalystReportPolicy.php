<?php

namespace App\Policies;

use App\Enums\PermissionEnum;
use App\Models\CatalystExplorer\CatalystReport;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CatalystReportPolicy extends AppPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasAnyPermission([PermissionEnum::read_twitter_attendances()->value]) || $this->canViewAny($user);
    }

    /**
     * Determine whether the user can view the model.
     *
     *
     * @throws \Exception
     */
    public function view(User $user, CatalystReport $CatalystReport): bool
    {
        return $user->hasAnyPermission([PermissionEnum::read_twitter_attendances()->value]) || $this->canView($user, $CatalystReport);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): Response|bool
    {
        return $user->hasAnyPermission([PermissionEnum::create_twitter_attendances()->value]) || $this->canCreate($user);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, CatalystReport $CatalystReport): Response|bool
    {
        return $user->hasAnyPermission([PermissionEnum::update_twitter_attendances()->value]) || $this->canUpdateAny($user);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, CatalystReport $CatalystReport): Response|bool
    {
        return $user->hasAnyPermission([PermissionEnum::delete_links()->value]) || $this->canDeleteAny($user);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, CatalystReport $CatalystReport): Response|bool
    {
        return $this->update($user, $CatalystReport);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, CatalystReport $CatalystReport): Response|bool
    {
        return $this->canDeleteAny($user);
    }
}
