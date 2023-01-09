<?php

namespace App\Listeners;

use App\Events\ArticleApproved;
use App\Mail\ContributionApprovedMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class SendArticleApprovedNotification implements ShouldQueue
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
     * @param  ArticleApproved  $event
     * @return void
     */
    public function handle(ArticleApproved $event)
    {
        Mail::to($event->post->metas->firstWhere('key', 'author_email')->content)
            ->send(new ContributionApprovedMail($event->post));
    }
}
