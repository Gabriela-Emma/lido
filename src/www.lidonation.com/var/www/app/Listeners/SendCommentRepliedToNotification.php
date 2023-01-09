<?php

namespace App\Listeners;

use App\Events\CommentRepliedTo;
use App\Mail\CommentRepliedToMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class SendCommentRepliedToNotification implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  CommentRepliedTo  $event
     * @return void
     */
    public function handle(CommentRepliedTo $event)
    {
        if (isset($event->comment->parent->email)) {
            Mail::to($event->comment->parent->email)
                ->send(new CommentRepliedToMail($event->comment));
        }
    }
}
