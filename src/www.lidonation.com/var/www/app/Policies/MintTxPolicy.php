<?php

namespace App\Policies;

use App\Enums\PermissionEnum;
use App\Models\MintTx;
use App\Models\User;

class MintTxPolicy extends AppPolicy
{
    /**
     * Determine whether the user can view any models.
     *
     * @param  User  $user
     * @return mixed
     */
    public function viewAny(User $user): mixed
    {
        return $user->hasAnyPermission([PermissionEnum::read_mint()->value]) || $this->canViewAny($user);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  User  $user
     * @param  MintTx  $mintTx
     * @return bool
     *
     * @throws \Exception
     */
    public function view(User $user, MintTx $mintTx): bool
    {
        return $user->hasAnyPermission([PermissionEnum::read_mint()->value]) || $this->canView($user, $mintTx);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  User  $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return $user->hasAnyPermission([PermissionEnum::create_mint()->value]) || $this->canCreate($user);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  User  $user
     * @param  MintTx  $mintTx
     * @return mixed
     */
    public function update(User $user, MintTx $mintTx): mixed
    {
        return $user->hasAnyPermission([PermissionEnum::update_mint()->value]) ||
            $this->canUpdate($user);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  User  $user
     * @param  MintTx  $mintTx
     * @return mixed
     */
    public function delete(User $user, MintTx $mintTx): mixed
    {
        return $user->hasAnyPermission([PermissionEnum::delete_mint()->value]) ||
        $this->canUpdate($user);
    }
}
