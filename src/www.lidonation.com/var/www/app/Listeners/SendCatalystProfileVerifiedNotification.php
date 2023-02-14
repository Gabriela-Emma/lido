<?php

namespace App\Listeners;

use App\Events\CatalystProfileVerified;
use App\Mail\CatalystProfileVerifiedMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class SendCatalystProfileVerifiedNotification implements ShouldQueue
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
     * @param  CatalystProfileVerified  $event
     * @return void
     */
    public function handle(CatalystProfileVerified $event)
    {
        if ($event->catalystUser?->notification_email) {
            Mail::to($event->catalystUser->notification_email)
                ->send(new CatalystProfileVerifiedMail($event->catalystUser));
        }
    }
}
