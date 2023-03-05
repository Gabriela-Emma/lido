<?php

namespace App\Listeners;

use App\Events\CommentPosted;
use App\Mail\CommentPostedMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class SendCommentPostedNotification implements ShouldQueue
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
     * @return void
     */
    public function handle(CommentPosted $event)
    {
        if (isset($event->comment->email)) {
            Mail::to($event->comment->email)
                ->send(new CommentPostedMail($event->comment));
        }
    }
}
