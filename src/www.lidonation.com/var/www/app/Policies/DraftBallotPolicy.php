<?php

namespace App\Policies;

use App\Models\DraftBallot;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class DraftBallotPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, DraftBallot $draftBallot): mixed
    {
        return Auth::id() == $draftBallot->user_id;
    }
}
