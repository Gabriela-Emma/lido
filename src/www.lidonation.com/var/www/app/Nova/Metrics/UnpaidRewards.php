<?php

namespace App\Nova\Metrics;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Partition;
use Laravel\Nova\Metrics\PartitionResult;

class UnpaidRewards extends Partition
{
    /**
     * Calculate the value of the metric.
     */
    public function calculate(NovaRequest $request): PartitionResult
    {
        $agg = DB::table('rewards')
            ->selectRaw('asset, SUM(amount) as sum')
            ->groupBy('asset')
            ->get()
            ->map(fn ($obj) => [
                match ($obj->asset) {
                    'a0028f350aaabe0545fdcb56b039bfb08e4bb4d8c4d7c3c7d481c235484f534b59' => 'Hosky',
                    '5dac8536653edc12f6f5e1045d8164b9f59998d3bdc300fc928434894e4d4b52' => 'NMKR',
                    '5612bee388219c1b76fd527ed0fa5aa1d28652838bcab4ee4ee63197446973636f696e' => 'DISCO',
                    'lovelace' => 'Ada',
                    null => 'None',
                    default => ucfirst($obj->asset),
                } => match ($obj->asset) {
                    '5dac8536653edc12f6f5e1045d8164b9f59998d3bdc300fc928434894e4d4b52' => intval(ceil($obj->sum / 1000000)),
                    'lovelace' => intval(ceil($obj->sum / 1000000)),
                    default => intval($obj->sum),
                },
            ])->collapse();

        return $this->result($agg?->toArray());
    }

    /**
     * Determine the amount of time the results of the metric should be cached.
     *
     * @return Carbon
     */
    public function cacheFor()
    {
        if (app()->environment('production')) {
            return now()->addMinutes(5);
        }
    }

    /**
     * Get the URI key for the metric.
     *
     * @return string
     */
    public function uriKey()
    {
        return 'unpaid-rewards';
    }
}
