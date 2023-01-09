<?php

namespace App\Policies;

use App\Enums\PermissionEnum;
use App\Models\TwitterAttendance;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TwitterAttendancePolicy extends AppPolicy
{
    /**
     * Determine whether the user can view any models.
     *
     * @param  User  $user
     * @return bool
     */
    public function viewAny(User $user): bool
    {
        return $user->hasAnyPermission([PermissionEnum::read_twitter_attendances()->value]) || $this->canViewAny($user);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  User  $user
     * @param  TwitterAttendance  $twitterAttendance
     * @return bool
     *
     * @throws \Exception
     */
    public function view(User $user, TwitterAttendance $twitterAttendance): bool
    {
        return $user->hasAnyPermission([PermissionEnum::read_twitter_attendances()->value]) || $this->canView($user, $twitterAttendance);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  User  $user
     * @return Response|bool
     */
    public function create(User $user): Response|bool
    {
        return $user->hasAnyPermission([PermissionEnum::create_twitter_attendances()->value]) || $this->canCreate($user);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  User  $user
     * @param  TwitterAttendance  $twitterAttendance
     * @return Response|bool
     */
    public function update(User $user, TwitterAttendance $twitterAttendance): Response|bool
    {
        return $user->hasAnyPermission([PermissionEnum::update_twitter_attendances()->value]) || $this->canUpdateAny($user);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  User  $user
     * @param  TwitterAttendance  $twitterAttendance
     * @return Response|bool
     */
    public function delete(User $user, TwitterAttendance $twitterAttendance): Response|bool
    {
        return $user->hasAnyPermission([PermissionEnum::delete_links()->value]) || $this->canDeleteAny($user);
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  User  $user
     * @param  TwitterAttendance  $twitterAttendance
     * @return Response|bool
     */
    public function restore(User $user, TwitterAttendance $twitterAttendance): Response|bool
    {
        return $this->update($user, $twitterAttendance);
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  User  $user
     * @param  TwitterAttendance  $twitterAttendance
     * @return Response|bool
     */
    public function forceDelete(User $user, TwitterAttendance $twitterAttendance): Response|bool
    {
        return $this->canDeleteAny($user);
    }
}
