<?php

namespace App\Repositories;

use App\Models\Post;
use App\Models\Review;
use Illuminate\Database\Eloquent\Builder;

class PostRepository extends Repository
{
    // Constructor to bind model to repo
    public function __construct(Post $model)
    {
        parent::__construct($model);
    }

    /**
     * @return mixed
     * Return posts in passed taxonomy class.
     * If no taxonomy is passed, you may pass mixed taxonomy types if passing in objects
     */
    public function inTaxonomies(string $taxonomyClass = null, ...$taxonomies): mixed
    {
        if (! isset($this->query)) {
            $this->query = Post::whereRaw('1=1');
        }

        return parent::inTaxonomies($taxonomyClass, $taxonomies);
    }

    public function models($types = [
        Post::class,
        Review::class,
    ])
    {
        $query = $this->query ?? $this->model;

        return $query->whereIn('type', $types)->get();
    }

    public function setModels($types = [
        Post::class,
        Review::class,
    ]): Builder
    {
        $query = Post::query();

        return $this->query = $query->whereIn('type', $types);
    }

    public function pending()
    {
    }
}
