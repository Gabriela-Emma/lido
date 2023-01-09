<?php

namespace App\Console\Commands;

use App\Jobs\SyncCatalystGroupProposalsJob;
use App\Models\CatalystGroup;
use Illuminate\Console\Command;

class SyncCatalystGroupProposals extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ln:cgp
            {ids?* : space delineated fields on model to translate}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync Catalyst Group Proposals and Challenges.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $cgIds = $this->argument('ids');
        if (! empty($cgIds)) {
            foreach ($cgIds as $cgId) {
                SyncCatalystGroupProposalsJob::dispatch($cgId);
            }
        } else {
            CatalystGroup::cursor()->each(fn (CatalystGroup $cg) => SyncCatalystGroupProposalsJob::dispatch($cg->id));
        }
    }
}
