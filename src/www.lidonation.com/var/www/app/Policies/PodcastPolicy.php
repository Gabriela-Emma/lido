<?php

namespace App\Policies;

use App\Enums\PermissionEnum;
use App\Models\Podcast;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PodcastPolicy extends AppPolicy
{
    /**
     * Determine whether the user can view any models.
     *
     * @param  User  $user
     * @return Response|bool
     */
    public function viewAny(User $user): Response|bool
    {
        return $user->hasAnyPermission([PermissionEnum::read_podcasts()->value]) || $this->canViewAny($user);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  User  $user
     * @param  Podcast  $podcast
     * @return bool
     *
     * @throws \Exception
     */
    public function view(User $user, Podcast $podcast): bool
    {
        return $user->hasAnyPermission([PermissionEnum::read_podcasts()->value]) || $this->canView($user, $podcast);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  User  $user
     * @return Response|bool
     */
    public function create(User $user): Response|bool
    {
        return $user->hasAnyPermission([PermissionEnum::create_podcasts()->value]) || $this->canCreate($user);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  User  $user
     * @param  Podcast  $podcast
     * @return Response|bool
     */
    public function update(User $user, Podcast $podcast): Response|bool
    {
        return $user->hasAnyPermission([PermissionEnum::update_podcasts()->value]) || $this->canUpdateAny($user);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  User  $user
     * @param  Podcast  $podcast
     * @return bool
     */
    public function delete(User $user, Podcast $podcast): bool
    {
        return $user->hasAnyPermission([PermissionEnum::delete_podcasts()->value]) || $this->canDeleteAny($user);
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  User  $user
     * @param  Podcast  $podcast
     * @return Response|bool
     */
    public function restore(User $user, Podcast $podcast): Response|bool
    {
        return $this->update($user, $podcast);
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  User  $user
     * @param  Podcast  $podcast
     * @return Response|bool
     */
    public function forceDelete(User $user, Podcast $podcast): Response|bool
    {
        return $this->canDeleteAny($user);
    }
}
