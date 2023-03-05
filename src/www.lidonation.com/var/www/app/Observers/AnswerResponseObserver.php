<?php

namespace App\Observers;

use App\Models\AnswerResponse;

class AnswerResponseObserver
{
    /**
     * Handle the User "created" event.
     */
    public function creating(AnswerResponse $answerResponse): void
    {
        if (! $answerResponse->user_id && auth()->check()) {
//            $answerResponse->user_id = auth()?->user()?->getAuthIdentifier();
        }
    }
}
