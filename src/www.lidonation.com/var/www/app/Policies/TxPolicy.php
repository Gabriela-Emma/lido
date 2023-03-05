<?php

namespace App\Policies;

use App\Enums\PermissionEnum;
use App\Models\Nft;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TxPolicy extends AppPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): Response|bool
    {
        return $user->hasAnyPermission([PermissionEnum::read_nfts()->value]) || $this->canViewAny($user);
    }

    /**
     * Determine whether the user can view the model.
     *
     *
     * @throws \Exception
     */
    public function view(User $user, Nft $nft): bool
    {
        return $user->hasAnyPermission([PermissionEnum::read_nfts()->value]) || $this->canView($user, $nft);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): Response|bool
    {
        return $user->hasAnyPermission([PermissionEnum::create_nfts()->value]) || $this->canCreate($user);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Nft $nft): Response|bool
    {
        return $user->hasAnyPermission([PermissionEnum::update_nfts()->value]) || $this->canUpdateAny($user);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Nft $nft): bool
    {
        return $user->hasAnyPermission([PermissionEnum::delete_nfts()->value]) || $this->canDeleteAny($user);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Nft $nft): Response|bool
    {
        return $this->update($user, $nft);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Nft $nft): Response|bool
    {
        return $this->canDeleteAny($user);
    }
}
