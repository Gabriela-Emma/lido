<?php

namespace App\Jobs;

use App\Actions\GitCmdRunner;
use App\Models\Commit;
use App\Models\Proposal;
use App\Models\Repo;
use App\Services\GitRepoService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SaveRepo implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(protected $url, protected $branchName, protected $proposal_id, protected $user_id)
    {
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $repoPath = GitRepoService::clone($this->url);
        $repoName = GitRepoService::repoName();

        //get repo details
        $repo = new Repo;
        $repo->user_id = $this->user_id;
        $repo->model_id = $this->proposal_id;
        $repo->model_type = Proposal::class;
        $repo->url = $this->url;
        $repo->name = $repoName;
        $repo->tracked_branch = $this->branchName;
        $repo->save();

        // get the commits of that repo

        $runner = new GitCmdRunner();
        $logOutput = $runner->run($repoPath, [
            'log',
            '--pretty=format:%h/ %an/ %ad/ %s',
            '--date=format:%Y-%m-%d %H:%M:%S',
            $this->branchName,
        ])->getOutputAsString();

        // dd($logOutput);
        // Explode by newline character to get each commit log line separately
        $logLines = explode("\n", $logOutput);

        // get list of commits
        $commits = [];
        foreach ($logLines as $line) {
            if (empty(trim($line))) {
                continue;
            }
            [$commitHash, $commitAuthor, $createdAt, $commitMessage] = explode('/', $line, 4);

            $commit = [
                'repo_id' => $repo->id,
                'hash' => $commitHash,
                'author' => $commitAuthor,
                'content' => $commitMessage,
                'created_at' => $createdAt,
            ];

            $commits[] = array_filter($commit);
        }

        // save the commits
        foreach ($commits as $commit) {
            $commit['repo_id'] = $repo->id;
            Commit::create($commit);
        }
    }
}
