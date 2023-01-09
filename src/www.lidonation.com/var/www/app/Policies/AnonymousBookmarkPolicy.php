<?php

namespace App\Policies;

use App\Enums\PermissionEnum;
use App\Models\AnonymousBookmark;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class AnonymousBookmarkPolicy extends AppPolicy
{
    /**
     * Determine whether the user can view any models.
     *
     * @param  User  $user
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
     * @param  User  $user
     * @param  AnonymousBookmark  $anonymousBookmark
     * @return Response|bool
     *
     * @throws \Exception
     */
    public function view(User $user, AnonymousBookmark $anonymousBookmark): Response|bool
    {
        return $user->hasAnyPermission([PermissionEnum::update_teams()->value]) ||
            $this->canView($user, $anonymousBookmark);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  User  $user
     * @return bool
     */
    public function create(User $user)
    {
        return $user->hasAnyPermission([PermissionEnum::update_teams()->value]) || $this->canCreate($user);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  User  $user
     * @param  AnonymousBookmark  $anonymousBookmark
     * @return Response|bool
     *
     * @throws \Exception
     */
    public function update(User $user, AnonymousBookmark $anonymousBookmark): Response|bool
    {
        return $user->hasAnyPermission([PermissionEnum::update_teams()->value]) ||
            $this->canUpdate($user);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  User  $user
     * @param  AnonymousBookmark  $anonymousBookmark
     * @return bool
     */
    public function delete(User $user, AnonymousBookmark $anonymousBookmark)
    {
        return $this->canDelete($user);
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  User  $user
     * @param  AnonymousBookmark  $anonymousBookmark
     * @return bool
     *
     * @throws \Exception
     */
    public function restore(User $user, AnonymousBookmark $anonymousBookmark): bool
    {
        return $user->hasAnyPermission([PermissionEnum::update_teams()->value]) || $this->canCreate($user);
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  User  $user
     * @param  AnonymousBookmark  $anonymousBookmark
     * @return bool
     */
    public function forceDelete(User $user, AnonymousBookmark $anonymousBookmark): bool
    {
        return $this->canDelete($user);
    }
}
