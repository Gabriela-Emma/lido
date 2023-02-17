<?php

namespace App\Http\Controllers\Api\CatalystExplorer;

use Illuminate\Http\Request;
use CzProject\GitPhp\Git;
use App\Actions\CmdRunner;

class RepoController extends Controller
{
    public function index(Request $request)
    {
        
        // validate url
        // $request->validate([
        //     'gitUrl'=> 'required|url'
        // ]);

        // // get branches
        // $runner = new CmdRunner;
        // $cmd = ['ls-remote', '--heads',$request->gitUrl];
        // $result = $runner->run('',$cmd);
        // $output = $result->getOutputAsString();
        // // dd($output);

        // $branches = [];
        // foreach (explode("\n",$output) as $line) {
        //     $parts = preg_split('/\t+/',$line);
        //     // dd($parts);
        //     $branch=str_replace('refs/heads/','',end($parts));
        //     $branches[]=$branch;
        // }
        // dd($branches);


        // cloning th
        
    
    }
}
