<?php

namespace App\Observers;

use App\Enums\RoleEnum;
use App\Jobs\SubscribeDelegatorMailchimpJob;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class UserObserver
{
    /**
     * Handle the LidoUser "created" event.
     */
    public function updating(User $user): void
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

    public function creating(User $user): void
    {
        $user->lang = app()->getLocale();
    }

    public function created(User $user): void
    {
        if (isset($user->wallet_stake_address) && $user->hasRole(RoleEnum::delegator()->value)) {
            try {
                SubscribeDelegatorMailchimpJob::dispatch($user->name, $user->email);
            } catch (\Exception $e) {
                Log::info($e->getMessage());
            }
        }
    }
}
