<?php

namespace App\Repositories;

use App\Models\Rating;
use Illuminate\Support\Facades\Auth;
use JetBrains\PhpStorm\Pure;

class RatingRepository extends Repository
{
    #[Pure]
    public function __construct(Rating $model)
    {
        parent::__construct($model);
    }

    public function create(array $data): Rating
    {
        $meta = null;
        if (isset($data['meta'])) {
            $meta = collect($data['meta']);
            unset($data['meta']);
        }

        $rating = new Rating;
        $rating->rating = $data['rating'];
        $rating->model_id = $data['model_id'];
        $rating->model_type = $data['model_type'];
        $rating->comment_id = $data['comment_id'];

        if (Auth::check()) {
            $rating->status = 'published';
        }
        $rating->save();

        // Maybe save meta
        $meta?->each(
            fn ($meta, $key) => $rating->saveMeta($key, $meta, $rating)
        );

        return $rating;
    }
}
