<?php

namespace App\Policies;

use App\Enums\PermissionEnum;
use App\Models\LearningLesson;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class LearningLessonPolicy extends AppPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param User $user
     * @return Response|bool
     */
    public function viewAny(User $user): Response|bool
    {
        return $user->hasAnyPermission([PermissionEnum::read_catalyst_groups()->value]) || $this->canViewAny($user);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param LearningLesson $learningLesson
     * @return Response|bool
     * @throws \Exception
     */
    public function view(User $user, LearningLesson $learningLesson): Response|bool
    {
        return $user->hasAnyPermission([PermissionEnum::read_catalyst_groups()->value]) || $this->canView($user, $learningLesson);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return bool
     */
    public function create(User $user)
    {
        return $user->hasAnyPermission([PermissionEnum::create_catalyst_groups()->value]) || $this->canCreate($user);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param LearningLesson $learningLesson
     * @return bool
     */
    public function update(User $user, LearningLesson $learningLesson): bool
    {
        return $user->hasAnyPermission([PermissionEnum::update_catalyst_groups()->value]) || $this->canUpdateAny($user);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param LearningLesson $learningLesson
     * @return Response|bool
     */
    public function delete(User $user, LearningLesson $learningLesson): Response|bool
    {
        return $user->hasAnyPermission([PermissionEnum::delete_catalyst_groups()->value]) || $this->canDeleteAny($user);
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param User $user
     * @param LearningLesson $learningLesson
     * @return Response|bool
     */
    public function restore(User $user, LearningLesson $learningLesson): Response|bool
    {
        return $user->hasAnyPermission([PermissionEnum::delete_catalyst_groups()->value]) || $this->canDeleteAny($user);
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param User $user
     * @param LearningLesson $learningLesson
     * @return Response|bool
     */
    public function forceDelete(User $user, LearningLesson $learningLesson): Response|bool
    {
        return $this->canDeleteAny($user);
    }
}
