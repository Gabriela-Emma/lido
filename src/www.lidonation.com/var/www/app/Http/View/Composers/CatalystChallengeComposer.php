<?php

namespace App\Http\View\Composers;

use App\Models\Proposal;
use App\Repositories\FundRepository;
use Illuminate\View\View;

class CatalystChallengeComposer
{
    /**
     * Create a new profile composer.
     *
     * @param  FundRepository  $fundRepository
     * @return void
     */
    public function __construct(protected FundRepository $fundRepository)
    {
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view): void
    {
        $fund = $this->fundRepository->get(
            request()
                ->route('fund')
        );
        $proposals = $fund->proposals()->with(['discussions.ratings'])->orderBy('title->en', 'desc')->paginate(24);

        $title = $fund->label;

        $totalProposalsCount = Proposal::where('type', 'challenge')
            ->where('fund_id', $fund->id)
            ->count();

        $fundedProposalsCount = Proposal::where('type', 'challenge')
            ->whereNotNull('funded_at')
            ->where('fund_id', $fund->id)
            ->count();

        $completedProposalsCount = Proposal::where(['status' => 'challenge'])
            ->where('type', 'proposal')
            ->where('fund_id', $fund->id)
            ->count();

        $totalAmountRequested = Proposal::where('type', 'challenge')
            ->where('fund_id', $fund->id)
            ->sum('amount_requested');

        $totalAmountAwarded = Proposal::where('type', 'challenge')
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
