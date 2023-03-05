<?php

namespace App\Http\Controllers\Api\CatalystExplorer;

use App\Models\Repo;
use App\Jobs\SaveRepo;
use App\Models\Commit;
use App\Models\Proposal;
use Illuminate\Http\Request;
use App\Actions\GitCmdRunner;

class RepoController extends Controller
{
    public function getBranches(Request $request)
    {
        $gitUrl = $request->input('gitUrl');

        $runner = new GitCmdRunner();
        $cmd = ['ls-remote', '--heads', $gitUrl];
        $result = $runner->run('', $cmd);
        $output = $result->getOutputAsString();
        // dd($output);

        $branches = [];
        foreach (explode("\n", $output) as $line) {
            $parts = preg_split('/\t+/', $line);
            // dd($parts);
            $branch = str_replace('refs/heads/', '', end($parts));
            $branches[] = $branch;
        }

        return array_filter($branches);
    }

    public function saveRepo(Request $request)
    {
        // dd($request);
        SaveRepo::dispatch($request->gitUrl, $request->branch, $request->proposal_id, $request->user_id);

        return 'Repository was saved';
    }

    public function updateRepo(Proposal $proposal, Request $request)
{  
    $existingRepo = Repo::where('model_id', $proposal->id)->first();

    commit::withoutGlobalScope('LimitScope');
    $existingCommitsIDs = Commit::where('repo_id', $existingRepo->id)->RemoveLimitScope()->pluck('id');

    
    // dd($existingCommitsIDs->count());

    // Check for changes
    $branchChange = ($request->branch != $existingRepo->tracked_branch) && ($request->gitUrl === $existingRepo->url);
    $repoChange = ($request->branch != $existingRepo->tracked_branch || $request->branch != $existingRepo->tracked_branch) && ($request->gitUrl != $existingRepo->url);

    // Handle changes
    if($branchChange){
        $existingRepo->tracked_branch = $request->branch;
        $existingRepo->save();
    }

    if($repoChange){
        Commit::destroy($existingCommitsIDs);
        
        Repo::where('model_id', $proposal->id)->delete();

        $this->saveRepo($request);
        
    }

    return "Update successful";
}
}
