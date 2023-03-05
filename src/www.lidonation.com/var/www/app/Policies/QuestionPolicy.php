<?php

namespace App\Policies;

use App\Enums\PermissionEnum;
use App\Models\Question;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class QuestionPolicy extends AppPolicy
{
    /**
     * Determine whether the user can view any models.
     *
     * @return Response|bool
     */
    public function viewAny(User $user)
    {
        return $user->hasAnyPermission([PermissionEnum::update_questions()->value]) ||
            $this->canViewAny($user);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @return Response|bool
     *
     * @throws \Exception
     */
    public function view(User $user, Question $question)
    {
        return $user->hasAnyPermission([PermissionEnum::update_questions()->value]) ||
            $this->canView($user, $question);
    }

    /**
     * Determine whether the user can create models.
     *
     * @return Response|bool
     */
    public function create(User $user)
    {
        return $user->hasAnyPermission([PermissionEnum::update_questions()->value]) || $this->canCreate($user);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @return Response|bool
     */
    public function update(User $user, Question $question)
    {
        return $user->hasAnyPermission([PermissionEnum::update_questions()->value]) ||
            $this->canUpdate($user);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @return Response|bool
     */
    public function delete(User $user, Question $question)
    {
        return $this->canDelete($user);
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @return bool
     */
    public function restore(User $user, Question $question)
    {
        return $user->hasAnyPermission([PermissionEnum::update_questions()->value]) || $this->canCreate($user);
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @return Response|bool
     */
    public function forceDelete(User $user, Question $question)
    {
        return $this->canDelete($user);
    }
}
