<?php

namespace App\Policies;

use App\Enums\PermissionEnum;
use App\Models\Snippet;
use App\Models\User;

class SnippetPolicy extends AppPolicy
{
    /**
     * Determine whether the user can view any models.
     *
     *
     * @throws \Exception
     */
    public function viewAny(User $user): mixed
    {
        return $user->hasAnyPermission([PermissionEnum::read_snippets()->value]) || $this->canViewAny($user);
    }

    /**
     * Determine whether the user can view the model.
     *
     *
     * @throws \Exception
     */
    public function view(User $user, Snippet $snippet): bool
    {
        return $user->hasAnyPermission([PermissionEnum::read_snippets()->value]) || $this->canView($user, $snippet);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasAnyPermission([PermissionEnum::create_snippets()->value]) || $this->canCreate($user);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Snippet $snippet): mixed
    {
        return $user->hasAnyPermission([PermissionEnum::update_snippets()->value]) || $this->canUpdateAny($user);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Snippet $snippet): mixed
    {
        return $user->hasAnyPermission([PermissionEnum::delete_snippets()->value]) || $this->canDeleteAny($user);
    }
}
