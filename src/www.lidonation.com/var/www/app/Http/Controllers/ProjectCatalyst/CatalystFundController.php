<?php

namespace App\Http\Controllers\ProjectCatalyst;

use App\Http\Controllers\Controller;
use App\Http\Resources\FundResource;
use App\Models\Fund;
use App\Models\Proposal;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\Request;

class CatalystFundController extends Controller
{
    public $type;
    public $fund;
    public $challenges;
    public function index(Request $request, $slug)
    {
        $this->fund = Fund::where('slug', $slug)->first();
        if ($this->fund) {
            $this->challenges = $this->fund->fundChallenges->map(function ($challenge) {
                return (new FundResource($challenge))->toArray(null);
            })->all();
        }
        $this->type = match ($this->fund?->type) {
            'challenge_setting' => 'challenge',
            default => 'proposal'
        };
        return Inertia::render('Fund', [
            'fund' => new FundResource($this->fund),
            'fundedProposalsCount' => $this->fundedProposals(),
            'completedProposalsCount' => $this->completedProposals(),
            'totalAmountRequested' => $this->totalAmountRequested(),
            'totalAmountAwarded' => $this->totalAmountAwarded(),
            'challenges' => $this->challenges,
            'challengesCount' => $this->fund->fundChallenges->count(),
            'crumbs' => [
                ['link' => '/catalyst-explorer/funds', 'label' => 'Funds'],
                ['label' => $this->fund->title],
            ]
        ]);
    }
    private function fundedProposals()
    {
        return Proposal::where('type', $this->type)
            ->whereNotNull('funded_at')
            ->whereIn('fund_id', $this->fund?->fundChallenges->pluck('id'))
            ->count();
    }
    private function completedProposals()
    {
        return Proposal::where([
            'status' => 'complete',
            'type' => $this->type,
        ])
            ->whereIn('fund_id', $this->fund?->fundChallenges->pluck('id'))
            ->count();
    }
    private function totalAmountRequested()
    {
        return Proposal::where('type', $this->type)
            ->whereIn('fund_id', $this->fund?->fundChallenges->pluck('id'))
            ->sum('amount_requested');
    }
    private function totalAmountAwarded()
    {
        return Proposal::where('type', $this->type)
            ->whereNotNull('funded_at')
            ->whereIn('fund_id',  $this->fund?->fundChallenges->pluck('id'))
            ->sum('amount_requested');
    }
}
