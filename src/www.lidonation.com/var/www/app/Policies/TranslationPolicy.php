<?php

namespace App\Policies;

use App\Enums\PermissionEnum;
use App\Models\Translation;
use App\Models\User;

class TranslationPolicy extends AppPolicy
{
    /**
     * Determine whether the user can view any models.
     *
     *
     * @throws \Exception
     */
    public function viewAny(User $user): bool
    {
        return $user->hasAnyPermission([PermissionEnum::translate_articles()->value]) || $this->canViewAny($user);
    }

    /**
     * Determine whether the user can view the model.
     *
     *
     * @throws \Exception
     */
    public function view(User $user, Translation $translation): bool
    {
        return $user->hasAnyPermission([PermissionEnum::translate_articles()->value]) || $this->canView($user, $translation);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasAnyPermission([PermissionEnum::translate_articles()->value]) || $this->canCreate($user);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Translation $translation): mixed
    {
        return $user->hasAnyPermission([PermissionEnum::update_translations()->value]) || $this->canUpdateAny($user);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Translation $translation): mixed
    {
        return $user->hasAnyPermission([PermissionEnum::delete_translations()->value]) || $this->canDeleteAny($user);
    }
}
