<?php

namespace App\Jobs;

use App\Models\Model;
use App\Models\CatalystVoter;
use App\Models\CatalystVotingPower;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Symfony\Component\Process\Process;
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
    public function __construct(public CatalystVotingPower $model)
    {
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $voter = CatalystVoter::where('cat_id', $this->model->voter_id)->first();
        $voting_key  = substr($voter->voting_key, 2);
        $command = './find --fragments ' . $this->fragment_storage . ' --voting-key ' . $voting_key;
        // $command = './find --fragments /data/catalyst-tools/ledger-snapshots/f10/persist/leader-1 --voting-key 1ccc5f1c512849edd71ae9afb0b5fcaeb9605e9decbff6d49b9ab6da5539787d';
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
