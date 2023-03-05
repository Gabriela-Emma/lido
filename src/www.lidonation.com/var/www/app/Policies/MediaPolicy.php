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
     *
     * @throws \Exception
     */
    public function view(User $user, Media $media): bool
    {
        return $user->hasAnyPermission([PermissionEnum::create_media()->value]) || $this->canView($user, $media);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasAnyPermission([PermissionEnum::create_media()->value]) || $this->canCreate($user);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Media $media): mixed
    {
        return $user->hasAnyPermission([PermissionEnum::update_media()->value]) || $this->canUpdateAny($user);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Media $media): mixed
    {
        return $user->hasAnyPermission([PermissionEnum::delete_media()->value]) || $this->canDeleteAny($user);
    }
}
