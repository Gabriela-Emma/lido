<?php

namespace App\Policies;

use App\Enums\PermissionEnum;
use App\Models\Link;
use App\Models\User;

class LinkPolicy extends AppPolicy
{
    /**
     * Determine whether the user can view any models.
     *
     * @param  User  $user
     * @return mixed
     *
     * @throws \Exception
     */
    public function viewAny(User $user): mixed
    {
        return $user->hasAnyPermission([PermissionEnum::read_links()->value]) || $this->canViewAny($user);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  User  $user
     * @param  Link  $link
     * @return bool
     *
     * @throws \Exception
     */
    public function view(User $user, Link $link): bool
    {
        return $user->hasAnyPermission([PermissionEnum::read_links()->value]) || $this->canView($user, $link);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  User  $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return $user->hasAnyPermission([PermissionEnum::create_links()->value]) || $this->canCreate($user);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  User  $user
     * @param  Link  $link
     * @return mixed
     */
    public function update(User $user, Link $link): mixed
    {
        return $user->hasAnyPermission([PermissionEnum::update_links()->value]) || $this->canUpdateAny($user);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  User  $user
     * @param  Link  $link
     * @return mixed
     */
    public function delete(User $user, Link $link): mixed
    {
        return $user->hasAnyPermission([PermissionEnum::delete_links()->value]) || $this->canDeleteAny($user);
    }
}
