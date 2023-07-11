<?php

namespace App\Http\Controllers\Api\CatalystExplorer;

use App\Actions\GitCmdRunner;
use App\Jobs\SaveRepo;
use App\Models\Commit;
use App\Models\Repo;
use Illuminate\Http\Request;

class RepoController extends Controller
{
    public function getBranches(Request $request)
    {
        $gitUrl = $request->input('gitUrl');

        $runner = new GitCmdRunner();
        $cmd = ['ls-remote', '--heads', $gitUrl];
        $result = $runner->run('', $cmd);
        $output = $result->getOutputAsString();

        $branches = [];
        foreach (explode("\n", $output) as $line) {
            $parts = preg_split('/\t+/', $line);
            $branch = str_replace('refs/heads/', '', end($parts));
            $branches[] = $branch;
        }

        return array_filter($branches);
    }

    public function store(Request $request)
    {
        SaveRepo::dispatch($request->gitUrl, $request->branch, $request->proposal_id, $request->user_id);

        return 'Repository was saved';
    }

    public function updateRepo(Request $request)
    {
        $existingRepo = Repo::where('model_id', $request->proposal_id)->first();

        Commit::withoutGlobalScope(LimitScope::class);
        $existingCommitsIDs = Commit::where('repo_id', $existingRepo->id)->pluck('id');

        // Check for changes
        $branchChange = ($request->branch != $existingRepo->tracked_branch) && ($request->gitUrl === $existingRepo->url);
        $repoChange = ($request->gitUrl != $existingRepo->url);

        // Handle changes
        if ($branchChange) {
            $existingRepo->tracked_branch = $request->branch;
            $existingRepo->save();
        }

        if ($repoChange) {
            Commit::destroy($existingCommitsIDs);

            $existingRepo->delete();

            $this->saveRepo($request);
        }

        return 'Update successful';
    }
}
