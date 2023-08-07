<?php

namespace App\Http\Controllers\ProjectCatalyst;

use App\Http\Controllers\Controller;
use App\Models\Fund;
use App\Models\Proposal;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Laravel\Scout\Builder;

class CatalystChallengeController extends Controller
{
    protected int $currentPage = 1;

    public int $perPage = 24;

    public function index(Request $request, $slug)
    {

        $fund = Fund::where('slug', $slug)->first();

        $props = [
            'fund' => $fund,
            'proposals' => $this->query($fund),
            'fundedProposalsCount' => $this->fundedProposals($fund),
            'completedProposalsCount' => $this->completedProposals($fund),
            'totalAmountRequested' => $this->totalAmountRequested($fund),
            'totalAmountAwarded' => $this->totalAmountAwarded($fund),
            'crumbs' => [
                ['label' => 'Funds'],
                ['label' => $fund->parent->label],
                ['label' => $fund->title]
            ],
        ];

        return Inertia::render('Challenge', $props);
    }

    private function fundedProposals($fund)
    {
        return Proposal::where('type', 'proposal')
            ->whereNotNull('funded_at')
            ->where('fund_id', $fund->id)
            ->count();
    }

    private function completedProposals($fund)
    {
        return Proposal::where([
            'status' => 'complete',
            'fund_id' =>  $fund->id
        ])
            ->count();
    }

    private function totalAmountRequested($fund)
    {
        return Proposal::where('type', 'proposal')
            ->where('fund_id', $fund->id)
            ->sum('amount_requested');
    }

    private function totalAmountAwarded($fund)
    {
        return Proposal::where('type', 'proposal')
            ->whereNotNull('funded_at')
            ->where('fund_id', $fund->id)
            ->sum('amount_requested');
    }

    public function query($fund)
    {
        $query = Proposal::where('fund_id', $fund->id);
        $paginator = $query->paginate($this->perPage, $this->currentPage, 'p');

        return $paginator->toArray();
    }
}
