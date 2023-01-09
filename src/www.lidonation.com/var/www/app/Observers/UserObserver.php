<?php

namespace App\Observers;

use App\Models\User;
use Illuminate\Support\Str;

class UserObserver
{
    /**
     * Handle the User "created" event.
     *
     * @param  User  $user
     * @return void
     */
    public function updating(User $user)
    {
        if ($user->facebook_user) {
            $user->saveMeta('facebook_user', $user->facebook_user, $user);
        }
        if ($user->twitter_handler) {
            $user->saveMeta('twitter_handler', Str::remove('@', $user->twitter_handler), $user);
        }
        if ($user->linkedin_user) {
            $user->saveMeta('linkedin_user', $user->linkedin_user, $user);
        }
        unset($user->linkedin_user);
        unset($user->twitter_handler);
        unset($user->facebook_user);
    }
}
