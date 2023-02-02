<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Artisan;

class CatalystProjectReportNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // getAllActiveNotificationRequestsTemplate
        // where type = CatalystReport
        // foreach item in related filter where not in NotificationRequests::where('what_id' and who_id)
            // create new NotificationRequest

        // In Observer
//            onCreate
//                *onCreate
                    // create new Mailable
                    // send
                    // update status
    }
}
