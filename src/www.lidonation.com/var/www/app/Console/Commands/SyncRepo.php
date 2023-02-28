<?php

namespace App\Console\Commands;

use App\Jobs\NewCommitsJob;
use App\Models\Repo;
use Illuminate\Console\Command;

class SyncRepo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:repo {repoIds?*} {--queue}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetching new commits';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Get the list of repo ids to process from the argument
        $repoIds = $this->argument('repoIds');

        // If no repo ids , get all repos from the database
        if (empty($repoIds)) {
            $repos = Repo::cursor();
        } else {
            // Get the repos with the provided ids
            $repos = Repo::whereIn('id', $repoIds)->cursor();
        }

        foreach ($repos as $repo) {
            NewCommitsJob::dispatch($repo);
        }
    }
}
