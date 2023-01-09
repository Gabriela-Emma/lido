<?php

namespace App\Http\View\Composers;

use App\Models\Category;
use App\Repositories\PostRepository;
use Illuminate\View\View;

class NoobsComposer
{
    /**
     * Create a new profile composer.
     *
     * @param  PostRepository  $posts
     * @return void
     */
    public function __construct(protected PostRepository $posts)
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
            'noobPosts' => $this->posts->inTaxonomies(Category::class, 'noobs'),
            'title' => 'Cardano and Blockchain for beginners',
        ]);
    }
}
