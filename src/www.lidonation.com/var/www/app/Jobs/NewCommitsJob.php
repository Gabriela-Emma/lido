<?php

namespace App\Jobs;

use App\Models\Repo;
use App\Models\Commit;
use App\Actions\GitCmdRunner;
use Illuminate\Bus\Queueable;
use App\Services\GitRepoService;
use Illuminate\Support\Facades\File;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class NewCommitsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

        /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(protected $repo)
    {
        
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $repoPath = storage_path('app/git-repos/'.$this->repo->name);
        $directories = File::directories(storage_path('app/git-repos/'));


        if (!in_array($repoPath, $directories))
        {
            $repoPath = GitRepoService::clone($this->repo->url);
        } 

        // Get the repo path and instantiate a new CmdRunner instance
        $runner = new GitCmdRunner();

        // Perform a git pull to update the local repository to the latest changes
        $runner->run($repoPath, ['pull']);

        // Fetch the latest commits for the branch
        $logOutput = $runner->run($repoPath, [
            'log',
            '--pretty=format:%h/ %an/ %ad/ %s',
            '--date=format:%Y-%m-%d %H:%M:%S',
            $this->repo->tracked_branch,
        ])->getOutputAsString();

        // Explode by newline character to get each commit log line separately
        $logLines = explode("\n", $logOutput);

        // Iterate through each log line and save new commits
        foreach ($logLines as $line) {
            if (empty(trim($line))) {
                continue;
            }
            [$commitHash, $commitAuthor, $createdAt, $commitMessage] = explode('/', $line, 4);

            // Check if the commit already exists
            $existingCommit = Commit::where('repo_id', $this->repo->id)
                ->where('hash', $commitHash)
                ->first();

            if (! $existingCommit) {
                // Save the new commit
                $commit = [
                    'repo_id' => $this->repo->id,
                    'hash' => $commitHash,
                    'author' => $commitAuthor,
                    'content' => $commitMessage,
                    'created_at' => $createdAt,
                ];

                Commit::create($commit);
            }
        }
    }
}

