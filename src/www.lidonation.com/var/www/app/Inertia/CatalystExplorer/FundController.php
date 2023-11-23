<?php

namespace App\Inertia\CatalystExplorer;

use App\Http\Controllers\Controller;
use App\Http\Resources\FundResource;
use App\Models\CatalystExplorer\Fund;
use App\Models\CatalystExplorer\Proposal;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class FundController extends Controller
{
    public $type;

    public $fund;

    public $challenges;

    public function index(Request $request, Fund $fund): Response
    {
        $this->fund = $fund;
        $this->challenges = $this->fund?->fundChallenges->map(function ($challenge) {
            return (new FundResource($challenge))->toArray(null);
        })->all();
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
            ],
        ]);
    }

    private function fundedProposals()
    {
        return Proposal::where('type', $this->type)
            ->whereNotNull('funded_at')
            ->whereIn('fund_id', $this->fund?->fundChallenges->pluck('id') ?? [])
            ->count();
    }

    private function completedProposals()
    {
        return Proposal::where([
            'status' => 'complete',
            'type' => $this->type,
        ])
            ->whereIn('fund_id', $this->fund?->fundChallenges->pluck('id') ?? [])
            ->count();
    }

    private function totalAmountRequested()
    {
        return Proposal::where('type', $this->type)
            ->whereIn('fund_id', $this->fund?->fundChallenges->pluck('id') ?? [])
            ->sum('amount_requested');
    }

    private function totalAmountAwarded()
    {
        return Proposal::where('type', $this->type)
            ->whereNotNull('funded_at')
            ->whereIn('fund_id', $this->fund?->fundChallenges->pluck('id') ?? [])
            ->sum('amount_requested');
    }
}
