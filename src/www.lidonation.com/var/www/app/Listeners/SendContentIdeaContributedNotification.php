<?php

namespace App\Listeners;

use App\Events\ContentIdeaContributed;
use App\Mail\IdeaContributedMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class SendContentIdeaContributedNotification implements ShouldQueue
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
    public function handle(ContentIdeaContributed $event)
    {
        Mail::to('hello@lidonation.com')
            ->send(new IdeaContributedMail($event->post));
    }
}
