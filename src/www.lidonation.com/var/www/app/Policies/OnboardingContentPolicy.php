<?php

namespace App\Policies;

use App\Enums\PermissionEnum;
use App\Models\OnboardingContent;
use App\Models\User;

class OnboardingContentPolicy extends AppPolicy
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
    public function view(User $user, OnboardingContent $onboardingContent): bool
    {
        return $user->hasAnyPermission([PermissionEnum::read_posts()->value]) || $this->canView($user, $onboardingContent);
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
    public function update(User $user, OnboardingContent $onboardingContent)
    {
        return $user->hasAnyPermission([PermissionEnum::update_posts()->value]) || $this->canUpdateAny($user);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @return mixed
     */
    public function delete(User $user, OnboardingContent $onboardingContent)
    {
        return $user->hasAnyPermission([PermissionEnum::delete_posts()->value]) || $this->canDeleteAny($user);
    }
}
