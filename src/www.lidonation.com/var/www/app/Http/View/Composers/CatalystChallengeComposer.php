<?php

namespace App\Http\View\Composers;

use App\Models\Fund;
use App\Models\Proposal;
use App\Repositories\FundRepository;
use Illuminate\View\View;

class CatalystChallengeComposer
{
    /**
     * Create a new profile composer.
     *
     * @return void
     */
    public function __construct(protected FundRepository $fundRepository)
    {
    }

    /**
     * Bind data to the view.
     */
    public function compose(View $view): void
    {
        $fund = $this->fundRepository->get(
            request()
                ->route('fund')
        );


        if (!$fund instanceof Fund ) {
            abort(404);
        }

        $proposals = $fund?->proposals()->with(['discussions.ratings'])->orderBy('title->en', 'desc')->paginate(24);

        $title = $fund->label;

        $totalProposalsCount = Proposal::where('type', 'proposal')
            ->where('fund_id', $fund->id)
            ->count();

        $fundedProposalsCount = Proposal::where('type', 'proposal')
            ->whereNotNull('funded_at')
            ->where('fund_id', $fund->id)
            ->count();

        $completedProposalsCount = Proposal::where(['status' => 'proposal'])
            ->where('type', 'proposal')
            ->where('fund_id', $fund->id)
            ->count();

        $totalAmountRequested = Proposal::where('type', 'proposal')
            ->where('fund_id', $fund->id)
            ->sum('amount_requested');

        $totalAmountAwarded = Proposal::where('type', 'proposal')
            ->whereNotNull('funded_at')
            ->where('fund_id', $fund->id)
            ->sum('amount_requested');


        $view->with(compact(
            'proposals',
            'title',
            'fund',
            'totalProposalsCount',
            'fundedProposalsCount',
            'completedProposalsCount',
            'totalAmountRequested',
            'totalAmountAwarded'
        ));
    }
}
