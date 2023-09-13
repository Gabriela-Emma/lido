<?php

namespace App\Console\Commands;

use App\Jobs\SyncF10ProposalCategories;
use Illuminate\Console\Command;

class SyncF10Categories extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ln:sync-f10-categories';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync F10 Proposal Categories';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        SyncF10ProposalCategories::dispatchSync();
    }
}
