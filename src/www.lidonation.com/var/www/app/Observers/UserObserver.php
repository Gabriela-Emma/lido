<?php

namespace App\Observers;

use App\Enums\RoleEnum;
use App\Models\User;
use App\Jobs\SubscribeDelegatorMailchimpJob;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

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

    public function created(User $user)
    {   
        if ( isset($user->wallet_stake_address) && in_array(RoleEnum::delegator()->value, (array) $user->roles->all()) ) {
            try {
                SubscribeDelegatorMailchimpJob::dispatch($user->name, $user->email);
           } catch (\Exception $e) {
                Log::info($e->getMessage());
           }
        }
    
    }
    
}
