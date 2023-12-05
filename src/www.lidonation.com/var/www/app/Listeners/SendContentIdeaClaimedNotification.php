<?php

namespace App\Listeners;

use App\Events\ContentIdeaClaimed;
use App\Mail\ContentIdeaClaimedMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class SendContentIdeaClaimedNotification implements ShouldQueue
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
    public function handle(ContentIdeaClaimed $event)
    {
        Mail::to('hello@lidonation.com')
            ->send(new ContentIdeaClaimedMail($event->post));
    }
}
