<?php

namespace App\Http\View\Composers;

use App\Models\Insight;
use App\Models\News;
use App\Repositories\PostRepository;
use Illuminate\View\View;

class PostComposer
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
    public function compose(View $view): void
    {
        $news = $this->posts->setModel(new News)->get(
            request()
                ->route('slug')
        );
        $insight = $this->posts->setModel(new Insight)->get(
            request()
                ->route('slug')
        );
        $post = $news ?? $insight;
        $title = $post?->title;
        $view->with(compact('post', 'title'));
    }
}
