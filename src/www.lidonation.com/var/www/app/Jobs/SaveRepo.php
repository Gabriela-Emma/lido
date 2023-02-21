<?php

namespace App\Jobs;

use App\Models\Repo;
use App\Actions\CmdRunner;
use App\Models\CatalystUser;
use App\Models\Commits;
use App\Models\Proposal;
use Illuminate\Bus\Queueable;
use App\Services\CloneRepoService;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class SaveRepo implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(protected $url,protected $branchName, protected $proposal_id ,protected $user_id)
    {

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $repoPath = CloneRepoService::clone($this->url);
        $repoName = CloneRepoService::repoName();

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

        $runner = new CmdRunner();
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
            list($commitHash, $commitAuthor, $createdAt, $commitMessage) = explode("/", $line, 4);
        
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
                Commits::create($commit);
            }

    }
}
