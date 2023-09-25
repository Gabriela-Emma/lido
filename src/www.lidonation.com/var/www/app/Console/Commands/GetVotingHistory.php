<?php

namespace App\Console\Commands;

use App\Models\Fund;
use App\Jobs\GetVoterHistory;
use Illuminate\Console\Command;
use App\Models\CatalystSnapshot;

class GetVotingHistory extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ln:get-vote-history {fund : fund_id} {--queue :  run asynchronously}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get voters voting history';

    /**
     * Execute the console command.
     *
     */
    public function handle(): void
    {
        $fund = Fund::find($this->argument('fund'));

        if (!$fund instanceof Fund) {
            $this->error('Fund is required.');

            return;
        }

        $snapshot = CatalystSnapshot::where('model_id', $fund->id)->first();

        if (!$snapshot instanceof CatalystSnapshot) {
            $this->error('Fund has no CatalystSnapshot.');

            return;
        }

        $snapshot->votingPowers()->orderBy('voting_power')->each(
            function ($power) {
                if ($this->option('queue')) {
                    GetVoterHistory::dispatch($power);
                } else {
                    GetVoterHistory::dispatchSync($power);
                }
            }
        );
    }
}
