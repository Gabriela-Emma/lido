<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use App\Jobs\CreateVotingPowerSnapshotJob;
use App\Models\CatalystSnapshot;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\LazyCollection;

class SyncVotingPowersFileJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $timeout = 60 * 3;

    // public $afterCommit = true;


    /**
     * Create a new job instance.
     */
    public function __construct(protected CatalystSnapshot $snapshot, protected $filePath, protected $header)
    {
          
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        LazyCollection::make(function () {
            $handle = fopen($this->filePath, 'r');
            
            while (($line = fgetcsv($handle, null)) !== false) {
                yield $line;
            }
    
            fclose($handle);
          })
          ->skip(1)
          ->chunk(50)
          ->each(function (LazyCollection $chunk) {
            $chunk->each(function ($row) {
                $voter = [];
                foreach ($this->header as $key => $value) {
                    $voter[$value] = $row[$key];
                };
                CreateVotingPowerSnapshotJob::dispatch($this->snapshot, $voter['stake_address'], $voter['voting_power']);
            });
        });
    }
}
