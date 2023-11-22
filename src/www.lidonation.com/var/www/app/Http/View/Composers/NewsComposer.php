<?php

namespace App\Http\View\Composers;

use App\Models\Post;
use App\Repositories\AdaRepository;
use App\Repositories\PostRepository;
use Illuminate\View\View;

class NewsComposer
{
    /**
     * Create a new profile composer.
     */
    public function __construct(
        protected PostRepository $posts,
        protected AdaRepository $adaRepository
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
            'title' => 'Cardano and Blockchain news',
            'news' => $this->posts->setModel(new Post)?->paginate(24),
        ]);
    }
}
