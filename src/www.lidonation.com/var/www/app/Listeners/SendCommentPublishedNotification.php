<?php

namespace App\Listeners;

use App\Events\CommentPublished;
use App\Mail\CommentPublishedMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class SendCommentPublishedNotification implements ShouldQueue
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
     * @param  CommentPublished  $event
     * @return void
     */
    public function handle(CommentPublished $event)
    {
        if (isset($event->comment->email)) {
            Mail::to($event->comment->email)
                ->send(new CommentPublishedMail($event->comment));
        }
    }
}
