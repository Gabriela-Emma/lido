<?php

namespace App\Http\View\Composers;

use App\Models\ExternalPost;
use App\Models\Post;
use App\Repositories\PostRepository;
use Illuminate\View\View;

class PostComposer
{
    /**
     * Create a new profile composer.
     *
     * @return void
     */
    public function __construct(protected PostRepository $posts)
    {
    }

    /**
     * Bind data to the view.
     */
    public function compose(View $view): void
    {
        $posts = $this->posts->setModel(new Post)->get(
            request()
                ->route('slug')
        );

        $externalPost = $this->posts->setModel(new ExternalPost)->get(
            request()
                ->route('slug')
        );

        $post = $posts ?? $externalPost;
        $title = $post?->title;
        $view->with(compact('post', 'title'));
    }
}
