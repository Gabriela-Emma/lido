<?php

namespace App\Policies;

use App\Enums\PermissionEnum;
use App\Models\BookmarkCollection;
use App\Models\User;

class BookmarkCollectionPolicy extends AppPolicy
{
    /**
     * Determine whether the user can view any models.
     *
     *
     * @throws \Exception
     */
    public function viewAny(User $user): bool
    {
        return $user->hasAnyPermission([PermissionEnum::read_catalyst_groups()->value]) || $this->canViewAny($user);
    }

    /**
     * Determine whether the user can view the model.
     *
     *
     * @throws \Exception
     */
    public function view(User $user, BookmarkCollection $bookmarkCollection): bool
    {
        return $user->hasAnyPermission([PermissionEnum::read_catalyst_groups()->value]) || $this->canView($user, $bookmarkCollection);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasAnyPermission([PermissionEnum::create_catalyst_groups()->value]) || $this->canCreate($user);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, BookmarkCollection $bookmarkCollection): bool
    {
        return $user->hasAnyPermission([PermissionEnum::update_catalyst_groups()->value]) || $this->canUpdateAny($user);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, BookmarkCollection $bookmarkCollection): bool
    {
        return $user->hasAnyPermission([PermissionEnum::delete_catalyst_groups()->value]) || $this->canDeleteAny($user);
    }
}
