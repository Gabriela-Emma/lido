<?php

namespace App\Policies;

use App\Enums\PermissionEnum;
use App\Models\Mint;
use App\Models\User;

class MintPolicy extends AppPolicy
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
     * @param  Mint  $mint
     * @return bool
     *
     * @throws \Exception
     */
    public function view(User $user, Mint $mint): bool
    {
        return $user->hasAnyPermission([PermissionEnum::read_mint()->value]) || $this->canView($user, $mint);
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
     * @param  Mint  $mint
     * @return mixed
     */
    public function update(User $user, Mint $mint): mixed
    {
        return $user->hasAnyPermission([PermissionEnum::update_mint()->value]) ||
            $this->canUpdate($user);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  User  $user
     * @param  Mint  $mint
     * @return mixed
     */
    public function delete(User $user, Mint $mint): mixed
    {
        return $user->hasAnyPermission([PermissionEnum::delete_mint()->value]) ||
        $this->canUpdate($user);
    }
}
