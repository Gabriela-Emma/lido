<?php

namespace App\Policies;

use App\Enums\PermissionEnum;
use App\Models\User;
use App\TranslationLoader\LanguageLine;

class LanguageLinePolicy extends AppPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): mixed
    {
        return $user->hasAnyPermission([PermissionEnum::read_posts()->value]) || $this->canViewAny($user);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, LanguageLine $languageLine): bool
    {
        return $user->hasAnyPermission([PermissionEnum::read_posts()->value]) || $this->canView($user, $languageLine);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasAnyPermission([PermissionEnum::create_posts()->value]) || $this->canCreate($user);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @return mixed
     */
    public function update(User $user, LanguageLine $languageLine)
    {
        return $user->hasAnyPermission([PermissionEnum::update_posts()->value]) || $this->canUpdateAny($user);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @return mixed
     */
    public function delete(User $user, LanguageLine $languageLine)
    {
        return $user->hasAnyPermission([PermissionEnum::delete_posts()->value]) || $this->canDeleteAny($user);
    }
}
