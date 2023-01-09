<?php

namespace App\Policies;

use App\Enums\PermissionEnum;
use App\Models\Team;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TeamPolicy extends AppPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  User  $user
     * @return mixed
     *
     * @throws \Exception
     */
    public function viewAny(User $user): bool
    {
        return $user->hasAnyPermission([PermissionEnum::update_proposals()->value]) || $this->canViewAny($user);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  User  $user
     * @param  Team  $team
     * @return mixed
     *
     * @throws \Exception
     */
    public function view(User $user, Team $team): bool
    {
        return $user->hasAnyPermission([PermissionEnum::update_proposals()->value]) || $this->canView($user, $team);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasAnyPermission([PermissionEnum::update_proposals()->value]) || $this->canCreate($user);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  User  $user
     * @param  Team  $team
     * @return mixed
     *
     * @throws \Exception
     */
    public function update(User $user, Team $team): bool
    {
        return $user->hasAnyPermission([PermissionEnum::update_proposals()->value]) ||
            $this->canUpdate($user) || $user->ownsTeam($team);
    }

    /**
     * Determine whether the user can add team members.
     *
     * @param  User  $user
     * @param  Team  $team
     * @return bool
     */
    public function addTeamMember(User $user, Team $team): bool
    {
        return $user->ownsTeam($team);
    }

    /**
     * Determine whether the user can update team member permissions.
     *
     * @param  User  $user
     * @param  Team  $team
     * @return mixed
     */
    public function updateTeamMember(User $user, Team $team): bool
    {
        return $user->ownsTeam($team);
    }

    /**
     * Determine whether the user can remove team members.
     *
     * @param  User  $user
     * @param  Team  $team
     * @return mixed
     */
    public function removeTeamMember(User $user, Team $team): bool
    {
        return $user->ownsTeam($team);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  User  $user
     * @param  Team  $team
     * @return mixed
     */
    public function delete(User $user, Team $team): bool
    {
        return $this->canDelete($user) || $user->ownsTeam($team);
    }
}
