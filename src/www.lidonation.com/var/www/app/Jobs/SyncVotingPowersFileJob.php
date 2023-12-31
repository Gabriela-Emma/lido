<?php

namespace App\Jobs;

use App\Models\CatalystExplorer\CatalystSnapshot;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\LazyCollection;

class SyncVotingPowersFileJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

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
            ->chunk(500)
            ->each(function (LazyCollection $chunk) {
                CreateVotingPowerSnapshotJob::dispatch($chunk, $this->snapshot?->id);
            });
    }
}
