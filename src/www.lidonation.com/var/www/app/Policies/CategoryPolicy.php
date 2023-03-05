<?php

namespace App\Policies;

use App\Enums\PermissionEnum;
use App\Models\Category;
use App\Models\User;

class CategoryPolicy extends AppPolicy
{
    /**
     * Determine whether the user can view any models.
     *
     *
     * @throws \Exception
     */
    public function viewAny(User $user): mixed
    {
        return $user->hasAnyPermission([PermissionEnum::read_categories()->value]) || $this->canViewAny($user);
    }

    /**
     * Determine whether the user can view the model.
     *
     *
     * @throws \Exception
     */
    public function view(User $user, Category $category): bool
    {
        return $user->hasAnyPermission([PermissionEnum::read_categories()->value]) || $this->canView($user, $category);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasAnyPermission([PermissionEnum::create_categories()->value]) || $this->canCreate($user);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Category $category): mixed
    {
        return $user->hasAnyPermission([PermissionEnum::update_categories()->value]) || $this->canUpdateAny($user);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Category $category): mixed
    {
        return $user->hasAnyPermission([PermissionEnum::delete_categories()->value]) || $this->canDeleteAny($user);
    }
}
