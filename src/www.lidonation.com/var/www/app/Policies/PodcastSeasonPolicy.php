<?php

namespace App\Policies;

use App\Enums\PermissionEnum;
use App\Models\PodcastSeason;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PodcastSeasonPolicy extends AppPolicy
{
    /**
     * Determine whether the user can view any models.
     *
     * @param  User  $user
     * @return Response|bool
     */
    public function viewAny(User $user): Response|bool
    {
        return $user->hasAnyPermission([PermissionEnum::read_podcast_seasons()->value]) || $this->canViewAny($user);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  User  $user
     * @param  PodcastSeason  $podcastSeason
     * @return bool
     *
     * @throws \Exception
     */
    public function view(User $user, PodcastSeason $podcastSeason): bool
    {
        return $user->hasAnyPermission([PermissionEnum::read_podcast_seasons()->value]) || $this->canView($user, $podcastSeason);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  User  $user
     * @return Response|bool
     */
    public function create(User $user): Response|bool
    {
        return $user->hasAnyPermission([PermissionEnum::create_podcast_seasons()->value]) || $this->canCreate($user);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  User  $user
     * @param  PodcastSeason  $podcastSeason
     * @return Response|bool
     */
    public function update(User $user, PodcastSeason $podcastSeason): Response|bool
    {
        return $user->hasAnyPermission([PermissionEnum::update_podcast_seasons()->value]) || $this->canUpdateAny($user);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  User  $user
     * @param  PodcastSeason  $podcastSeason
     * @return bool
     */
    public function delete(User $user, PodcastSeason $podcastSeason): bool
    {
        return $user->hasAnyPermission([PermissionEnum::delete_podcast_seasons()->value]) || $this->canDeleteAny($user);
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  User  $user
     * @param  PodcastSeason  $podcastSeason
     * @return Response|bool
     */
    public function restore(User $user, PodcastSeason $podcastSeason): Response|bool
    {
        return $this->update($user, $podcastSeason);
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  User  $user
     * @param  PodcastSeason  $podcastSeason
     * @return Response|bool
     */
    public function forceDelete(User $user, PodcastSeason $podcastSeason): Response|bool
    {
        return $this->canDeleteAny($user);
    }
}
