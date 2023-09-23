<?php

namespace App\Jobs;

use App\Models\Model;
use App\Models\CatalystVoter;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class GetVoterHistory implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $fragment_storage = '/data/catalyst-tools/ledger-snapshots/f10/persist/leader-1';
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(public CatalystVoter $model)
    {
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $voting_key  = substr($this->model->voting_key,2);
        $command = '/opt/catalyst-tools/release/find --fragments ' . $this->fragment_storage . ' --voting-key ' . $voting_key;
        exec($command);
    }
}
