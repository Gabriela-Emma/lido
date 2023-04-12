<?php

namespace App\Policies;

use App\Enums\PermissionEnum;
use App\Models\LearningLesson;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class LearningLessonPolicy extends AppPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        return $user->hasAnyPermission([PermissionEnum::read_catalyst_groups()->value]) || $this->canViewAny($user);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\LearningLesson  $learningLesson
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, LearningLesson $learningLesson)
    {
        return $user->hasAnyPermission([PermissionEnum::read_catalyst_groups()->value]) || $this->canView($user, $learningLesson);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $user->hasAnyPermission([PermissionEnum::create_catalyst_groups()->value]) || $this->canCreate($user);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\LearningLesson  $learningLesson
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, LearningLesson $learningLesson)
    {
        return $user->hasAnyPermission([PermissionEnum::update_catalyst_groups()->value]) || $this->canUpdateAny($user);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\LearningLesson  $learningLesson
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, LearningLesson $learningLesson)
    {
        return $user->hasAnyPermission([PermissionEnum::delete_catalyst_groups()->value]) || $this->canDeleteAny($user);
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\LearningLesson  $learningLesson
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, LearningLesson $learningLesson)
    {
        return $user->hasAnyPermission([PermissionEnum::delete_catalyst_groups()->value]) || $this->canDeleteAny($user);
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\LearningLesson  $learningLesson
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, LearningLesson $learningLesson)
    {
        // return true;
    }
}
