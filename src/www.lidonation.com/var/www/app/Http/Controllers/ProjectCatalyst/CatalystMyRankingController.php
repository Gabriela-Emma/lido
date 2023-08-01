<?php

namespace App\Http\Controllers\ProjectCatalyst;

use App\Http\Controllers\Controller;
use App\Models\CatalystRank;
use App\Models\CatalystVote;
use App\Models\Proposal;
use Illuminate\Http\Request;

class CatalystMyRankingController extends Controller
{
    // views
    public function index()
    {

    }

    public function view()
    {

    }

    public function create()
    {

    }

    public function ranks(Request $request)
    {
        $ranks = CatalystRank::withTrashed()
            ->where('user_id', auth()?->user()?->id)
            ->get()
            ->map(function($rank) {
                return [
                    'id' => $rank['id'],
                    'rank' => $rank['rank'],
                    'model_id' => $rank['model_id'], 
                ];
            });

        return response()->json($ranks, 200);
    }

    // actions
    public function store(Request $request)
    {
        $data = $request->validate([
            'proposal' => 'required|exists:proposals,id',
            'rankValue' => 'required|in:1,-1',
        ]);
        
        $proposal = Proposal::find($data['proposal']);
        $rank = new CatalystRank;
        $rank->user_id = auth()->id();
        $rank->model_id = $proposal->id;
        $rank->model_type = Proposal::class;
        $rank->rank = $data['rankValue'];
        $rank->save();
        redirect()->back();
    }

    public function update(Request $request, $rank)
    {
        $data = $request->validate([
            'rankValue' => 'required|in:0,1,-1',
        ]);

        $rank = CatalystRank::withTrashed()
            ->where('id', $rank)
            ->first();

        // Check if the new ranking is the same as the existing vote (if so delete else update rank)
        if($data['rankValue'] == $rank->rank){
            $rank->rank = 0;
            $rank->save();
            $rank->delete();
        } else{
            ($rank->deleted_at != null) ? $rank->restore() : '';
            $rank->rank = $data['rankValue'];
    
            $rank->save();
        }
        redirect()->back();
    }

    public function destroy(Request $request, CatalystVote $vote)
    {
        $vote->delete();
    }
}
