<?php

namespace App\Listeners;

use App\Events\ContentContributed;
use App\Mail\ContentContributedMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class SendContentContributedNotification implements ShouldQueue
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
     * @param  ContentContributed  $event
     * @return void
     */
    public function handle(ContentContributed $event)
    {
        Mail::to('hello@lidonation.com')
            ->send(new ContentContributedMail($event->post));
    }
}
