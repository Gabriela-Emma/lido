<?php

namespace App\Nova\Metrics;

use App\Models\LearningLesson;
use App\Models\Reward;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Value;
use Laravel\Nova\Metrics\ValueResult;

class TotalAdaDistributed extends Value
{
    /**
     * Calculate the value of the metric.
     */
    public function calculate(NovaRequest $request): ValueResult
    {
        $slteLovelaceDistributed = Reward::where('asset_type', 'ada')
            ->where('model_type', LearningLesson::class)
            ->whereIn('status', ['processed', 'claimed', 'paid']);

        return $this->sum($request, $slteLovelaceDistributed, 'amount')
            ->transform(fn ($value) => $value / 1000000)
            ->currency('₳');
    }

    /**
     * Get the ranges available for the metric.
     */
    public function ranges(): array
    {
        return [
            30 => __('30 Days'),
            15 => __('15 Days'),
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
     */
    public function uriKey(): string
    {
        return 'total-ada-distributed';
    }

    public function name(): string
    {
        return 'Total Ada Distributed';
    }
}
