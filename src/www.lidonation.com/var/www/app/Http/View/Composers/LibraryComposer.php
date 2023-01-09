<?php

namespace App\Http\View\Composers;

use App\Models\Insight;
use App\Models\Review;
use App\Repositories\PostRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\View;

class LibraryComposer
{
    private array|Collection $insights;

    private array|Collection $reviews;

    /**
     * Create a new profile composer.
     *
     * @param  PostRepository  $posts
     * @return void
     */
    public function __construct(
        protected PostRepository $posts
    ) {
        $this->insights = $this->posts->setModel(new Insight)->limit(6)->all();
        $this->reviews = $this->posts->setModel(new Review)->limit(6)->all();
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
            //            'news' => $this->posts->news(), // loading in GlobalComposer
            'insights' => $this->insights,
            'reviews' => $this->reviews,
            'title' => 'LIDO Nation Library',
        ]);
    }
}
