<?php

namespace App\Http\Controllers\ProjectCatalyst;

use App\Http\Controllers\Controller;
use App\Models\CatalystVote;
use App\Models\Proposal;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Inertia\Inertia;
use Inertia\Response;

class CatalystMyVotesController extends Controller
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
        // TODO: check if user is allowed to edit this vote
        $data = $request->validate([
            'vote' => 'required|in:0,1,2',
        ]);
        $vote->content = $data['content'] ?? '';
        $vote->vote = $data['vote'];

        $vote->save();
        redirect()->back();
    }

    public function destroy(Request $request, CatalystVote $vote)
    {
        // TODO: check if user is allowed to edit this vote
        $vote->delete();
    }
}
