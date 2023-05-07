<?php

namespace App\Nova\Metrics;

use App\Models\Insight;
use App\Models\News;
use App\Models\Post;
use App\Models\Review;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Value;
use Laravel\Nova\Metrics\ValueResult;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class NewArticleRecordings extends Value
{
    /**
     * Calculate the value of the metric.
     *
     * @return ValueResult
     */
    public function calculate(NovaRequest $request)
    {
        return $this->count($request, Media::distinct('model_id')
            ->where([
                'collection_name' => 'audio',
            ])->whereIn('model_type', [
                Post::class,
                News::class,
                Insight::class,
                Review::class,
            ]));
    }

    /**
     * Get the ranges available for the metric.
     *
     * @return array
     */
    public function ranges()
    {
        return [
            5 => '5 Days',
            10 => '10 Days',
            15 => '15 Days',
            30 => '30 Days',
        ];
    }

    /**
     * Determine for how many minutes the metric should be cached.
     *
     * @return  \DateTimeInterface
     */
    public function cacheFor()
    {
        //         return now()->addMinutes(5);
    }

    /**
     * Get the URI key for the metric.
     */
    public function uriKey(): string
    {
        return 'new-article-recordings';
    }
}
