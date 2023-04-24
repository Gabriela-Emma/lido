<?php

namespace App\Observers;

use App\Invokables\FillPostData;
use App\Jobs\GenerateReviewRatingImagesJob;
use App\Models\Rating;
use Illuminate\Support\Facades\Log;

class RatingObserver
{
    /**
     * Handle the Rating "created" event.
     *
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
     * @return void
     */
    public function created(Rating $rating)
    {
        if ($rating->model) {
            try {
                GenerateReviewRatingImagesJob::dispatch($rating->model?->model);
            } catch (\Throwable $err) {
                Log::error('The rating image could not be generated.');
            }
        }
    }

    public function deleting(Rating $rating)
    {
        if ($rating->forceDeleting) {
            $rating->metas()->delete();
        }
    }
}
