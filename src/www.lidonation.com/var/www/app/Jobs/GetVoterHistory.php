<?php

namespace App\Jobs;

use App\Models\Model;
use JsonMachine\Items;
use App\Models\CatalystVoter;
use Illuminate\Bus\Queueable;
use App\Models\CatalystVotingPower;
use Illuminate\Queue\SerializesModels;
use Symfony\Component\Process\Process;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Throwable;

class GetVoterHistory implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $fragment_storage = '/data/catalyst-tools/ledger-snapshots/f10/persist/leader-1';
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(public CatalystVotingPower $model)
    {
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
        $voter = CatalystVoter::where('cat_id', $this->model->voter_id)->first();

        if(!$voter instanceof CatalystVoter){
            return;
        }
        $voting_key  = substr($voter->voting_key, 2);
        $command = './find --fragments ' . $this->fragment_storage . ' --voting-key ' . $voting_key;
        $workingDirectory = '/opt/catalyst-tools';

        $process = Process::fromShellCommandline($command, $workingDirectory);
        $process->start();
        $process->wait();

        $sourcePath = '/tmp/offline.voting_history_of_' . $voting_key . '.json';
        $destinationPath = '/data/catalyst-tools/voting-history/f10/' . $voter->stake_pub . '.json';
        $jsonContents = file_get_contents($sourcePath);
        if (empty($jsonContents) || $jsonContents === '[]') {
            unlink($sourcePath);
        } else {
            rename($sourcePath, $destinationPath);
        }
    }
}
