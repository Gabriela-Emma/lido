<?php

namespace App\Http\View\Composers;

use App\Repositories\PoolRepository;
use Illuminate\View\View;

class PurposeDrivenPoolComposer
{
    /**
     * Create a new profile composer.
     *
     * @param  PoolRepository  $pools
     * @return void
     */
    public function __construct(protected PoolRepository $pools)
    {
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with([
            //            'causes' => []
        ]);
    }
}
