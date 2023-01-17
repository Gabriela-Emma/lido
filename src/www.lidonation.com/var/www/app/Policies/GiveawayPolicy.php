<?php

namespace App\Policies;

use App\Enums\PermissionEnum;
use App\Models\Giveaway;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class GiveawayPolicy extends AppPolicy
{
    /**
     * Determine whether the user can view any models.
     *
     * @param  User  $user
     * @return Response|bool
     */
    public function viewAny(User $user)
    {
        return $user->hasAnyPermission([PermissionEnum::update_giveaways()->value]) ||
            $this->canViewAny($user);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  User  $user
     * @param  Giveaway  $giveaway
     * @return Response|bool
     *
     * @throws \Exception
     */
    public function view(User $user, Giveaway $giveaway)
    {
        return $user->hasAnyPermission([PermissionEnum::update_giveaways()->value]) ||
            $this->canView($user, $giveaway);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  User  $user
     * @return Response|bool
     */
    public function create(User $user)
    {
        return $user->hasAnyPermission([PermissionEnum::update_giveaways()->value]) || $this->canCreate($user);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  User  $user
     * @param  Giveaway  $giveaway
     * @return Response|bool
     */
    public function update(User $user, Giveaway $giveaway)
    {
        return $user->hasAnyPermission([PermissionEnum::update_giveaways()->value]) ||
            $this->canUpdate($user);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  User  $user
     * @param  Giveaway  $giveaway
     * @return Response|bool
     */
    public function delete(User $user, Giveaway $giveaway)
    {
        return $this->canDelete($user);
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  User  $user
     * @param  Giveaway  $giveaway
     * @return bool
     */
    public function restore(User $user, Giveaway $giveaway)
    {
        return $user->hasAnyPermission([PermissionEnum::update_giveaways()->value]) || $this->canCreate($user);
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  User  $user
     * @param  Giveaway  $giveaway
     * @return Response|bool
     */
    public function forceDelete(User $user, Giveaway $giveaway)
    {
        return $this->canDelete($user);
    }
}
