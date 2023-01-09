<?php

namespace App\Observers;

use App\Invokables\FillPostData;
use App\Jobs\GenerateReviewRatingImagesJob;
use App\Models\Rating;

class RatingObserver
{
    /**
     * Handle the Rating "created" event.
     *
     * @param  Rating  $rating
     * @return void
     */
    public function creating(Rating $rating)
    {
        (new FillPostData)($rating, [], fn () => [
            'model_type' => ['type', $rating->comment?->model_type],
        ]);
    }

    /**
     * Handle the Rating "created" event.
     *
     * @param  Rating  $rating
     * @return void
     */
    public function created(Rating $rating)
    {
        if ($rating->model) {
            GenerateReviewRatingImagesJob::dispatch($rating->model?->model);
        }
    }

    public function deleting(Rating $rating)
    {
        if ($rating->forceDeleting) {
            $rating->metas()->delete();
        }
    }
}
