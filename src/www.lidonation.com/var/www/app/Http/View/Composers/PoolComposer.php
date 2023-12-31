<?php

namespace App\Http\View\Composers;

use App\Repositories\PoolRepository;
use Illuminate\View\View;

class PoolComposer
{
    /**
     * Create a new profile composer.
     *
     * @return void
     */
    public function __construct(protected PoolRepository $pools)
    {
    }

    /**
     * Bind data to the view.
     *
     * @return void
     */
    public function compose(View $view)
    {
        $view->with([
            'pools' => [], // $this->pools->active()
        ]);
    }
}
