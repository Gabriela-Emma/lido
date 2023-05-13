<?php

namespace App\Nova\Metrics;

use App\Models\LearningLesson;
use App\Models\Reward;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Value;

class TotalAdaEarned extends Value
{
    /**
     * Calculate the value of the metric.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return mixed
     */
    public function calculate(NovaRequest $request)
    {
        $lteAdaRewards = Reward::where('asset_type', 'ada')
                        ->where('model_type', LearningLesson::class);

        return $this->sum($request, $lteAdaRewards, 'amount')
                    ->transform(fn($value) => $value / 1000000)
                    ->currency('₳');
    }

    /**
     * Get the ranges available for the metric.
     *
     * @return array
     */
    public function ranges()
    {
        return [
            30 => __('30 Days'),
            60 => __('60 Days'),
            365 => __('365 Days'),
            'TODAY' => __('Today'),
            'MTD' => __('Month To Date'),
            'QTD' => __('Quarter To Date'),
            'YTD' => __('Year To Date'),
        ];
    }

    /**
     * Determine the amount of time the results of the metric should be cached.
     *
     * @return \DateTimeInterface|\DateInterval|float|int|null
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
        return 'total-ada-earned';
    }

    public function name()
    {
        return 'Total Ada Earned (lte)';
    }
}
