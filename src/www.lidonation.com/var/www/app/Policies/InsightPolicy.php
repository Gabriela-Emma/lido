<?php

namespace App\Policies;

use App\Enums\PermissionEnum;
use App\Models\Insight;
use App\Models\User;

class InsightPolicy extends AppPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): mixed
    {
        return $user->hasAnyPermission([PermissionEnum::read_insights()->value]) || $this->canViewAny($user);
    }

    /**
     * Determine whether the user can view the model.
     *
     *
     * @throws \Exception
     */
    public function view(User $user, Insight $insight): bool
    {
        return $user->hasAnyPermission([PermissionEnum::read_insights()->value]) || $this->canView($user, $insight);
    }

    /**
     * Determine whether the user can create models.
     *
     *
     * @throws \Exception
     */
    public function create(User $user): bool
    {
        return $user->hasAnyPermission([PermissionEnum::create_insights()->value]) || $this->canCreate($user);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function update(User $user, Insight $insight)
    {
        return $user->hasAnyPermission([PermissionEnum::update_insights()->value]) || $this->canUpdateAny($user);
    }

    /**
     * Determine whether the user can delete the model.
     *
     *
     * @throws \Exception
     */
    public function delete(User $user, Insight $insight): mixed
    {
        return $user->hasAnyPermission([PermissionEnum::delete_insights()->value]) || $this->canDeleteAny($user);
    }
}
