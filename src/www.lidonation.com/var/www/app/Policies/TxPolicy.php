<?php

namespace App\Policies;

use App\Enums\PermissionEnum;
use App\Models\Nft;
use App\Models\Tx;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class TxPolicy extends AppPolicy
{
    /**
     * Determine whether the user can view any models.
     *
     * @param  User  $user
     * @return Response|bool
     */
    public function viewAny(User $user): Response|bool
    {
        return $user->hasAnyPermission([PermissionEnum::read_nfts()->value]) || $this->canViewAny($user);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  User  $user
     * @param  Nft  $nft
     * @return bool
     *
     * @throws \Exception
     */
    public function view(User $user, Nft $nft): bool
    {
        return $user->hasAnyPermission([PermissionEnum::read_nfts()->value]) || $this->canView($user, $nft);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  User  $user
     * @return Response|bool
     */
    public function create(User $user): Response|bool
    {
        return $user->hasAnyPermission([PermissionEnum::create_nfts()->value]) || $this->canCreate($user);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  User  $user
     * @param  Nft  $nft
     * @return Response|bool
     */
    public function update(User $user, Nft $nft): Response|bool
    {
        return $user->hasAnyPermission([PermissionEnum::update_nfts()->value]) || $this->canUpdateAny($user);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  User  $user
     * @param  Nft  $nft
     * @return bool
     */
    public function delete(User $user, Nft $nft): bool
    {
        return $user->hasAnyPermission([PermissionEnum::delete_nfts()->value]) || $this->canDeleteAny($user);
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  User  $user
     * @param  Nft  $nft
     * @return Response|bool
     */
    public function restore(User $user, Nft $nft): Response|bool
    {
        return $this->update($user, $nft);
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  User  $user
     * @param  Nft  $nft
     * @return Response|bool
     */
    public function forceDelete(User $user, Nft $nft): Response|bool
    {
        return $this->canDeleteAny($user);
    }
}
