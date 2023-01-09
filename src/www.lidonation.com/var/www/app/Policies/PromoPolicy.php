<?php

namespace App\Policies;

use App\Enums\PermissionEnum;
use App\Models\Promo;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PromoPolicy extends AppPolicy
{
    /**
     * Determine whether the user can view any models.
     *
     * @param  User  $user
     * @return Response|bool
     */
    public function viewAny(User $user): Response|bool
    {
        return $user->hasAnyPermission([PermissionEnum::read_promos()->value]) || $this->canViewAny($user);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  User  $user
     * @param  Promo  $promo
     * @return bool
     *
     * @throws \Exception
     */
    public function view(User $user, Promo $promo): bool
    {
        return $user->hasAnyPermission([PermissionEnum::read_promos()->value]) || $this->canView($user, $promo);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  User  $user
     * @return Response|bool
     */
    public function create(User $user): Response|bool
    {
        return $user->hasAnyPermission([PermissionEnum::create_promos()->value]) || $this->canCreate($user);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  User  $user
     * @param  Promo  $promo
     * @return Response|bool
     */
    public function update(User $user, Promo $promo): Response|bool
    {
        return $user->hasAnyPermission([PermissionEnum::update_promos()->value]) || $this->canUpdateAny($user);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  User  $user
     * @param  Promo  $promo
     * @return bool
     */
    public function delete(User $user, Promo $promo): bool
    {
        return $user->hasAnyPermission([PermissionEnum::delete_promos()->value]) || $this->canDeleteAny($user);
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  User  $user
     * @param  Promo  $promo
     * @return Response|bool
     */
    public function restore(User $user, Promo $promo): Response|bool
    {
        return $this->update($user, $promo);
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  User  $user
     * @param  Promo  $promo
     * @return Response|bool
     */
    public function forceDelete(User $user, Promo $promo): Response|bool
    {
        return $this->canDeleteAny($user);
    }
}
