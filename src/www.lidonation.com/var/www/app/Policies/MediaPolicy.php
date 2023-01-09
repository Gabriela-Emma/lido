<?php

namespace App\Policies;

use App\Enums\PermissionEnum;
use App\Models\User;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class MediaPolicy extends AppPolicy
{
    /**
     * Determine whether the user can view any models.
     *
     * @param  User  $user
     * @return mixed
     *
     * @throws \Exception
     */
    public function viewAny(User $user): mixed
    {
        return $user->hasAnyPermission([PermissionEnum::create_media()->value]) || $this->canViewAny($user);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  User  $user
     * @param  Media  $media
     * @return bool
     *
     * @throws \Exception
     */
    public function view(User $user, Media $media): bool
    {
        return $user->hasAnyPermission([PermissionEnum::create_media()->value]) || $this->canView($user, $media);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  User  $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return $user->hasAnyPermission([PermissionEnum::create_media()->value]) || $this->canCreate($user);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  User  $user
     * @param  Media  $media
     * @return mixed
     */
    public function update(User $user, Media $media): mixed
    {
        return $user->hasAnyPermission([PermissionEnum::update_media()->value]) || $this->canUpdateAny($user);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  User  $user
     * @param  Media  $media
     * @return mixed
     */
    public function delete(User $user, Media $media): mixed
    {
        return $user->hasAnyPermission([PermissionEnum::delete_media()->value]) || $this->canDeleteAny($user);
    }
}
