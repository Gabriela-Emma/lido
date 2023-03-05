<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Tpetry\PostgresqlEnhanced\Support\Facades\Schema;

class UpdateProposalRatingMView implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Refresh the view.
     */
    public function handle(): void
    {
        Schema::refreshMaterializedView('_proposal_ratings');
    }
}
