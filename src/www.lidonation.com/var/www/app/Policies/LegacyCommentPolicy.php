<?php

namespace App\Policies;

use App\Enums\PermissionEnum;
use App\Models\Assessment;
use App\Models\User;

class LegacyCommentPolicy extends AppPolicy
{
    /**
     * Determine whether the user can view any models.
     *
     *
     * @throws \Exception
     */
    public function viewAny(User $user): bool
    {
        return $user->hasAnyPermission([PermissionEnum::read_legacy_comments()->value]) || $this->canViewAny($user);
    }

    /**
     * Determine whether the user can view the model.
     *
     *
     * @throws \Exception
     */
    public function view(User $user, Assessment $legacyComment): bool
    {
        return $user->hasAnyPermission([PermissionEnum::read_legacy_comments()->value]) || $this->canView($user, $legacyComment);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasAnyPermission([PermissionEnum::create_legacy_comments()->value]) || $this->canCreate($user);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Assessment $legacyComment): bool
    {
        return $user->hasAnyPermission([PermissionEnum::update_legacy_comments()->value]) || $this->canUpdateAny($user);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Assessment $legacyComment): bool
    {
        return $user->hasAnyPermission([PermissionEnum::delete_legacy_comments()->value]) || $this->canDeleteAny($user);
    }
}
