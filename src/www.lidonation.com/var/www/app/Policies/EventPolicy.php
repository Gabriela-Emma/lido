<?php

namespace App\Policies;

use App\Enums\PermissionEnum;
use App\Models\Event;
use App\Models\User;

class EventPolicy extends AppPolicy
{
    /**
     * Determine whether the user can view any models.
     *
     * @param  User  $user
     * @return bool
     *
     * @throws \Exception
     */
    public function viewAny(User $user): bool
    {
        return $user->hasAnyPermission([PermissionEnum::read_events()->value]) || $this->canViewAny($user);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  User  $user
     * @param  Event  $event
     * @return bool
     *
     * @throws \Exception
     */
    public function view(User $user, Event $event): bool
    {
        return $user->hasAnyPermission([PermissionEnum::read_events()->value]) || $this->canView($user, $event);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  User  $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return $user->hasAnyPermission([PermissionEnum::create_events()->value]) || $this->canCreate($user);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  User  $user
     * @param  Event  $event
     * @return bool
     */
    public function update(User $user, Event $event): bool
    {
        return $user->hasAnyPermission([PermissionEnum::update_events()->value]) || $this->canUpdateAny($user);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  User  $user
     * @param  Event  $event
     * @return bool
     */
    public function delete(User $user, Event $event): bool
    {
        return $user->hasAnyPermission([PermissionEnum::delete_events()->value]) || $this->canDeleteAny($user);
    }
}
