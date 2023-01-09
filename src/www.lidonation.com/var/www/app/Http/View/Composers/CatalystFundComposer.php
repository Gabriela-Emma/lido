<?php

namespace App\Http\View\Composers;

use App\Repositories\FundRepository;
use Illuminate\View\View;

class CatalystFundComposer
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
        $challenges = $fund->fundChallenges()
            ->withCount(
                [
                    'proposals as funded_proposals_count' => function ($query) {
                        $query->whereNotNull('funded_at')->where('type', 'proposal');
                    }, ],
            )->orderBy('title', 'desc')->paginate(24);

        $title = $fund->label;
        $view->with(compact('challenges', 'title', 'fund'));
    }
}
