<?php

namespace App\Policies;

use App\Enums\PermissionEnum;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Auth\Access\Response;

class WalletPolicy extends AppPolicy
{
    /**
     * Determine whether the user can view any models.
     *
     * @return bool
     *
     * @throws \Exception
     */
    public function viewAny(User $user)
    {
        return $user->hasAnyPermission([PermissionEnum::update_teams()->value]) ||
            $this->canViewAny($user);
    }

    /**
     * Determine whether the user can view the model.
     *
     *
     * @throws \Exception
     */
    public function view(User $user, Wallet $wallet): Response|bool
    {
        return $user->hasAnyPermission([PermissionEnum::update_teams()->value]) ||
            $this->canView($user, $wallet);
    }

    /**
     * Determine whether the user can create models.
     *
     * @return bool
     */
    public function create(User $user)
    {
        return $user->hasAnyPermission([PermissionEnum::update_teams()->value]) || $this->canCreate($user);
    }

    /**
     * Determine whether the user can update the model.
     *
     *
     * @throws \Exception
     */
    public function update(User $user, Wallet $wallet): Response|bool
    {
        return $user->hasAnyPermission([PermissionEnum::update_teams()->value]) ||
            $this->canUpdate($user);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @return bool
     */
    public function delete(User $user, Wallet $wallet)
    {
        return $this->canDelete($user);
    }

    /**
     * Determine whether the user can restore the model.
     *
     *
     * @throws \Exception
     */
    public function restore(User $user, Wallet $wallet): bool
    {
        return $user->hasAnyPermission([PermissionEnum::update_teams()->value]) || $this->canCreate($user);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Wallet $wallet): bool
    {
        return $this->canDelete($user);
    }
}
