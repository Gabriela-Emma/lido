<?php

namespace App\Inertia\CatalystExplorer;

use App\Http\Controllers\Controller;
use App\Models\CatalystExplorer\CatalystVote;
use App\Models\CatalystExplorer\Proposal;
use Illuminate\Http\Request;

class MyVotesController extends Controller
{
    // views
    public function index(Proposal $proposal)
    {

        return $proposal->vote?->first();

    }

    public function view()
    {

    }

    public function create()
    {

    }

    // actions
    public function store(Request $request)
    {
        $data = $request->validate([
            'proposal' => 'required|exists:proposals,id',
            'vote' => 'required|in:0,1,2',
        ]);
        $proposal = Proposal::find($data['proposal']);
        $vote = new CatalystVote;
        $vote->user_id = auth()->id();
        $vote->model_id = $proposal->id;
        $vote->model_type = Proposal::class;
        $vote->content = $data['content'] ?? '';
        $vote->vote = $data['vote'];
        $vote->save();
        redirect()->back();
    }

    public function update(Request $request, CatalystVote $vote)
    {
        $data = $request->validate([
            'vote' => 'required|in:0,1,2',
        ]);

        // Check if the new vote is the same as the existing vote
        if ($data['vote'] == $vote->vote) {
            $vote->delete();
        } else {
            $vote->content = $data['content'] ?? '';
            $vote->vote = $data['vote'];

            $vote->save();
        }
        redirect()->back();
    }

    public function destroy(Request $request, CatalystVote $vote)
    {
        $vote->delete();
    }
}
