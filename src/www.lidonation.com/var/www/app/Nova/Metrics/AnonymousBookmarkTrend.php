<?php

namespace App\Nova\Metrics;

use App\Models\AnonymousBookmark;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Trend;
use Laravel\Nova\Metrics\TrendResult;

class AnonymousBookmarkTrend extends Trend
{
    /**
     * Calculate the value of the metric.
     *
     * @param  NovaRequest  $request
     * @return TrendResult
     */
    public function calculate(NovaRequest $request): TrendResult
    {
        return $this->countByDays($request, AnonymousBookmark::class)->showSumValue();
    }

    /**
     * Get the ranges available for the metric.
     *
     * @return array
     */
    public function ranges(): array
    {
        return [
            30 => __('30 Days'),
            60 => __('60 Days'),
            90 => __('90 Days'),
        ];
    }

    /**
     * Determine the amount of time the results of the metric should be cached.
     *
     * @return void
     */
    public function cacheFor()
    {
        // return now()->addMinutes(5);
    }

    /**
     * Get the URI key for the metric.
     *
     * @return string
     */
    public function uriKey()
    {
        return 'anonymous-bookmark-trend';
    }
}
