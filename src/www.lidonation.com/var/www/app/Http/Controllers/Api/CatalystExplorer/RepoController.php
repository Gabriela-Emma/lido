<?php

namespace App\Http\Controllers\Api\CatalystExplorer;

use Inertia\Inertia;
use App\Jobs\SaveRepo;
use App\Actions\CmdRunner;
use Illuminate\Http\Request;

class RepoController extends Controller
{
    public function getBranches(Request $request)
    {   
        $gitUrl = $request->input('gitUrl');

        $runner = new CmdRunner();
        $cmd = ['ls-remote', '--heads',$gitUrl];
        $result = $runner->run('',$cmd);
        $output = $result->getOutputAsString();
        // dd($output);

        $branches = [];
        foreach (explode("\n",$output) as $line) {
            $parts = preg_split('/\t+/',$line);
            // dd($parts);
            $branch=str_replace('refs/heads/','',end($parts));
            $branches[]=$branch;
        }
        return (array_filter($branches));

    }
    public function saveRepo(Request $request)
    {
        // dd($request);
        SaveRepo::dispatch($request->gitUrl, $request->branch, $request->proposal_id, $request->user_id);

        return ('Repository was saved');
      
    }
    
}
