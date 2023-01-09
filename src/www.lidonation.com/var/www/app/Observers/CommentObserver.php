<?php

namespace App\Observers;

use App\Models\Comment;
use App\Models\User;

class CommentObserver
{
    /**
     * Handle the User "created" event.
     *
     * @param  Comment  $comment
     * @return void
     */
    public function creating(Comment $comment)
    {
        if (! $comment->commentator_id) {
            $comment->commentator_id = User::where('email', config('app.default_commenter_email'))->first()?->id;
            $comment->commentator_type = User::class;
        }
    }
}
