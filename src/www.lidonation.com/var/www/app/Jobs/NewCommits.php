<?php

namespace App\Jobs;

use App\Models\Repo;
use App\Models\Commits;
use App\Actions\CmdRunner;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\File;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class NewCommits implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle()
    {
        
            // Get all the directories in the repo path
        $repoPath = storage_path('app/repo');
        $directories = File::directories($repoPath);

        foreach ($directories as $directory) {
            // Check if the directory is a valid Git repository
            if (!File::exists($directory . '/.git')) {
                continue;
            }

            // Get the repo path and instantiate a new CmdRunner instance
            $repoPath = realpath($directory);
            $runner = new CmdRunner();

            // Perform a git pull to update the local repository to the latest changes
            $runner->run($repoPath, ['pull']);

            $repo = Repo::where('name', $directory)->first();
            if (!$repo) {
                continue;
            }

            // Fetch the latest commits for the branch
            $logOutput = $runner->run($repoPath, [
                'log', 
                '--pretty=format:%h/ %an/ %ad/ %s',
                '--date=format:%Y-%m-%d %H:%M:%S',
                $repo->tracked_branch,
            ])->getOutputAsString();

            // Explode by newline character to get each commit log line separately
            $logLines = explode("\n", $logOutput);

            // Iterate through each log line and save new commits
            foreach ($logLines as $line) {
                if (empty(trim($line))) {
                    continue;
                }
                list($commitHash, $commitAuthor, $createdAt, $commitMessage) = explode("/", $line, 4);

                // Check if the commit already exists
                $existingCommit = Commits::where('repo_id', $repo->id)
                    ->where('hash', $commitHash)
                    ->first();

                if (!$existingCommit) {
                    // Save the new commit
                    $commit = [
                        'repo_id' => $repo->id,
                        'hash' => $commitHash,
                        'author' => $commitAuthor,
                        'content' => $commitMessage,
                        'created_at' => $createdAt,
                    ];

                    Commits::create($commit);
                }
            }
        }
    }
}
