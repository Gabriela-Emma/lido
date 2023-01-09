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
     * @param  PostRepository  $posts
     * @return void
     */
    public function __construct(
        protected PostRepository $posts
    ) {
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
            'insights' => $this->posts->setModel(new Insight)->paginate(24),
            'title' => 'Cardano and Blockchain Insights',
        ]);
    }
}
