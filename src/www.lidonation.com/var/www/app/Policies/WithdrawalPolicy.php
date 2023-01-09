<?php

namespace App\Policies;

use App\Enums\PermissionEnum;
use App\Models\Withdrawal;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class WithdrawalPolicy extends AppPolicy
{

    /**
     * Determine whether the user can view any models.
     *
     * @param  User  $user
     * @return Response|bool
     */
    public function viewAny(User $user): Response|bool
    {
        return $user->hasAnyPermission([PermissionEnum::read_withdrawals()->value]) || $this->canViewAny($user);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  User  $user
     * @param  Withdrawal  $withdrawal
     * @return bool
     *
     * @throws \Exception
     */
    public function view(User $user, Withdrawal $withdrawal): bool
    {
        return $user->hasAnyPermission([PermissionEnum::read_withdrawals()->value]) || $this->canView($user, $withdrawal);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  User  $user
     * @return Response|bool
     */
    public function create(User $user): Response|bool
    {
        return $user->hasAnyPermission([PermissionEnum::create_withdrawals()->value]) || $this->canCreate($user);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  User  $user
     * @param  Withdrawal  $withdrawal
     * @return Response|bool
     */
    public function update(User $user, Withdrawal $withdrawal): Response|bool
    {
        return $user->hasAnyPermission([PermissionEnum::update_withdrawals()->value]) || $this->canUpdateAny($user);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  User  $user
     * @param  Withdrawal  $withdrawal
     * @return bool
     */
    public function delete(User $user, Withdrawal $withdrawal): bool
    {
        return $user->hasAnyPermission([PermissionEnum::delete_withdrawals()->value]) || $this->canDeleteAny($user);
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  User  $user
     * @param  Withdrawal  $withdrawal
     * @return Response|bool
     */
    public function restore(User $user, Withdrawal $withdrawal): Response|bool
    {
        return $this->update($user, $withdrawal);
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  User  $user
     * @param  Withdrawal  $withdrawal
     * @return Response|bool
     */
    public function forceDelete(User $user, Withdrawal $withdrawal): Response|bool
    {
        return $this->canDeleteAny($user);
    }
}
