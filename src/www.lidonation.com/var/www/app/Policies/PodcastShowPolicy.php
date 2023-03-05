<?php

namespace App\Policies;

use App\Enums\PermissionEnum;
use App\Models\PodcastShow;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PodcastShowPolicy extends AppPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): Response|bool
    {
        return $user->hasAnyPermission([PermissionEnum::read_podcast_shows()->value]) || $this->canViewAny($user);
    }

    /**
     * Determine whether the user can view the model.
     *
     *
     * @throws \Exception
     */
    public function view(User $user, PodcastShow $podcastShow): bool
    {
        return $user->hasAnyPermission([PermissionEnum::read_podcast_shows()->value]) || $this->canView($user, $podcastShow);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): Response|bool
    {
        return $user->hasAnyPermission([PermissionEnum::create_podcast_shows()->value]) || $this->canCreate($user);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, PodcastShow $podcastShow): Response|bool
    {
        return $user->hasAnyPermission([PermissionEnum::update_podcast_shows()->value]) || $this->canUpdateAny($user);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, PodcastShow $podcastShow): bool
    {
        return $user->hasAnyPermission([PermissionEnum::delete_podcast_shows()->value]) || $this->canDeleteAny($user);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, PodcastShow $podcastShow): Response|bool
    {
        return $this->update($user, $podcastShow);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, PodcastShow $podcastShow): Response|bool
    {
        return $this->canDeleteAny($user);
    }
}
