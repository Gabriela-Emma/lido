<?php

namespace App\Http\View\Composers;

use App\Repositories\CauseRepository;
use App\Repositories\VoteRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\View;

class CausesComposer
{
    private LengthAwarePaginator $causes;

    private Collection $votes;

    /**
     * Create a new profile composer.
     */
    public function __construct(protected CauseRepository $causeRepository, protected VoteRepository $voteRepository)
    {
        $this->causes = $this->causeRepository->paginate();
        $this->votes = $this->voteRepository->all();
    }

    /**
     * Bind data to the view.
     *
     * @return void
     */
    public function compose(View $view)
    {
        $view->with(
            [
                'causes' => $this->causes,
                'votes' => $this->votes,
            ]
        );
    }
}
