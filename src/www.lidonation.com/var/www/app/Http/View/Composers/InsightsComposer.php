<?php

namespace App\Http\View\Composers;

use App\Models\Insight;
use App\Repositories\PostRepository;
use Illuminate\View\View;

class InsightsComposer
{
    /**
     * Create a new profile composer.
     *
     * @return void
     */
    public function __construct(
        protected PostRepository $posts
    ) {
    }

    /**
     * Bind data to the view.
     *
     * @return void
     */
    public function compose(View $view)
    {
        $view->with([
            'insights' => $this->posts->setModel(new Insight)->fastPaginate(24),
            'title' => 'Cardano and Blockchain Insights',
        ]);
    }
}
