<?php

namespace App\Nova\Metrics;

use App\Models\User;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Partition;
use Laravel\Nova\Metrics\Value;

class WalletsStakedPercentage extends Partition
{
    /**
     * Calculate the value of the metric.
     *
     * @return mixed
     */
    public function calculate(NovaRequest $request)
    {
        $learners = User::role('learner')->includeDuplicates(false);

        $totalWallets = $learners->whereRaw('Length(wallet_stake_address) > 5')
            ->count();
        $delegatedWallets = $learners->whereRaw('Length(active_pool_id) > 5 ')
            ->count();

        return $this->result([
            'Delegated' => $delegatedWallets,
            'Not Delegated' => $totalWallets - $delegatedWallets,
        ])->colors(['green', 'red']);
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
        return 'wallets-staked';
    }

    public function name()
    {
        return 'Wallets Staked';
    }
}
