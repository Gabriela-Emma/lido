<?php

namespace App\Policies;

use App\Enums\PermissionEnum;
use App\Models\Setting;
use App\Models\User;

class SettingPolicy extends AppPolicy
{
    /**
     * Determine whether the user can view any models.
     *
     * @param  User  $user
     * @return bool
     */
    public function viewAny(User $user): bool
    {
        return $user->hasAnyPermission([PermissionEnum::read_settings()->value]) || $this->canViewAny($user);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  User  $user
     * @param  Setting  $setting
     * @return bool
     *
     * @throws \Exception
     */
    public function view(User $user, Setting $setting): bool
    {
        return $user->hasAnyPermission([PermissionEnum::read_settings()->value]) || $this->canView($user, $setting);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  User  $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return $user->hasAnyPermission([PermissionEnum::create_settings()->value]) || $this->canCreate($user);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  User  $user
     * @param  Setting  $setting
     * @return bool
     */
    public function update(User $user, Setting $setting): bool
    {
        return $user->hasAnyPermission([PermissionEnum::update_settings()->value]) ||
            $this->canUpdate($user);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  User  $user
     * @param  Setting  $setting
     * @return bool
     */
    public function delete(User $user, Setting $setting): bool
    {
        return $user->hasAnyPermission([PermissionEnum::delete_settings()->value]);
    }
}
