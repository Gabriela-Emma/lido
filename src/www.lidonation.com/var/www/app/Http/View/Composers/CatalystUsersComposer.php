<?php

namespace App\Http\View\Composers;

use App\Repositories\CatalystUserRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\View\View;

class CatalystUsersComposer
{
    private LengthAwarePaginator $users;

    /**
     * Create a new profile composer.
     *
     * @param  CatalystUserRepository  $catalystUserRepository
     * @return void
     */
    public function __construct(protected CatalystUserRepository $catalystUserRepository)
    {
        $this->users = $this->catalystUserRepository->paginate(24);
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with(
            [
                'metaTitle' => __('Project Catalyst Proposers'),
                'catalystUsers' => $this->users,
                'catalystUsersCount' => $this->users->total(),
            ]
        );
    }
}
