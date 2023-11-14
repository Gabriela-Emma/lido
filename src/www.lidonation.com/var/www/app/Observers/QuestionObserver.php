<?php

namespace App\Observers;

use App\Models\Question;

class QuestionObserver
{
    /**
     * Handle the LidoUser "created" event.
     */
    public function creating(Question $question): void
    {
        if (! $question->user_id && auth()->check()) {
            $question->user_id = auth()?->user()?->getAuthIdentifier();
        }
    }
}
