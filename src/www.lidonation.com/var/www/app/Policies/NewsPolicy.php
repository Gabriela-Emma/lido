<?php

namespace App\Policies;

use App\Enums\PermissionEnum;
use App\Models\News;
use App\Models\User;

class NewsPolicy extends AppPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): mixed
    {
        return $user->hasAnyPermission([PermissionEnum::create_news()->value]) || $this->canViewAny($user);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, News $news): bool
    {
        return $user->hasAnyPermission([PermissionEnum::create_news()->value]) || $this->canView($user, $news);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasAnyPermission([PermissionEnum::create_news()->value]) || $this->canCreate($user);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @return mixed
     */
    public function update(User $user, News $news)
    {
        return $user->hasAnyPermission([PermissionEnum::update_news()->value]) || $this->canUpdateAny($user);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @return mixed
     */
    public function delete(User $user, News $news)
    {
        return $user->hasAnyPermission([PermissionEnum::delete_news()->value]) || $this->canDeleteAny($user);
    }
}
