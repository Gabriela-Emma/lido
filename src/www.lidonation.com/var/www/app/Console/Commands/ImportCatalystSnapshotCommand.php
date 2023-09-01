<?php

namespace App\Console\Commands;

use App\Jobs\SyncCatalystVotingPowersJob;
use App\Models\CatalystSnapshot;
use App\Models\Fund;
use Illuminate\Support\Fluent;
use App\Services\SyncCatalystSnapshotService;
use JsonMachine\Items;
use Illuminate\Console\Command;

class ImportCatalystSnapshotCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ln:import-catalyst-snapshot-powers {snapshot} {file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import Catalyst Snaphot voting power from a file.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $snapshot = $this->argument('snapshot');
        $file = $this->argument('file');
        $votingPowers = Items::fromFile($file);

        $snapshot = CatalystSnapshot::findOrFail($snapshot);
        if (is_null($snapshot)) {
            $this->error('Snapshot is required.');
            return;
        }

        foreach($votingPowers as $vp) {
            $vp = new Fluent($vp);

            dispatch(new SyncCatalystVotingPowersJob(
                snapshot: $snapshot->id,
                voterId: $vp->address,
                votingPower: $vp->value
            ));
        }
    }
}
