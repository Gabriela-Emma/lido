<?php

namespace App\Policies;

use App\Enums\PermissionEnum;
use App\Models\Quiz;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class QuizPolicy extends AppPolicy
{
    /**
     * Determine whether the user can view any models.
     *
     * @param  User  $user
     * @return Response|bool
     */
    public function viewAny(User $user)
    {
        return $user->hasAnyPermission([PermissionEnum::update_quizzes()->value]) ||
            $this->canViewAny($user);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  User  $user
     * @param  Quiz  $quiz
     * @return Response|bool
     */
    public function view(User $user, Quiz $quiz)
    {
        return $user->hasAnyPermission([PermissionEnum::update_quizzes()->value]) ||
            $this->canView($user, $quiz);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  User  $user
     * @return Response|bool
     */
    public function create(User $user)
    {
        return $user->hasAnyPermission([PermissionEnum::update_quizzes()->value]) || $this->canCreate($user);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  User  $user
     * @param  Quiz  $quiz
     * @return Response|bool
     */
    public function update(User $user, Quiz $quiz)
    {
        return $user->hasAnyPermission([PermissionEnum::update_quizzes()->value]) ||
            $this->canUpdate($user);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  User  $user
     * @param  Quiz  $quiz
     * @return Response|bool
     */
    public function delete(User $user, Quiz $quiz)
    {
        return $this->canDelete($user);
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  User  $user
     * @param  Quiz  $quiz
     * @return bool
     */
    public function restore(User $user, Quiz $quiz)
    {
        return $user->hasAnyPermission([PermissionEnum::update_quizzes()->value]) || $this->canCreate($user);
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  User  $user
     * @param  Quiz  $quiz
     * @return Response|bool
     */
    public function forceDelete(User $user, Quiz $quiz)
    {
        return $this->canDelete($user);
    }
}
