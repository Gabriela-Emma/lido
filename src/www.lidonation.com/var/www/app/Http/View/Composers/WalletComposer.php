<?php

namespace App\Http\View\Composers;

use App\Services\CardanoGraphQLService;
use Carbon\Carbon;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\View\View;
use Whoops\Exception\ErrorException;

class WalletComposer
{
    /**
     * Create a new profile composer.
     *
     * @return void
     */
    public function __construct(protected CardanoGraphQLService $graphQLService)
    {
    }

    /**
     * Bind data to the view.
     *
     * @return void
     *
     * @throws GuzzleException
     */
    public function compose(View $view)
    {
        try {
//            [$rewards, $rewardsAggregate] = $this->graphQLService->getStakingRewardTxs(null, true);
//            [$txs, $aggregate] = $this->graphQLService->getStakeAddressTokenTxs(null, null, true);
            // $txs = $this->graphQLService->getAddressesTokenUtxos(config('cardano.mint.policies.phuffycoin'));
//            $rewards = $rewards?->map(function ($reward) {
//                $reward->type = 'reward';
//                $reward->date = Carbon::make($reward->date);
//
//                return $reward;
//            });

//            $txs = $txs?->map(function ($tx) {
//                $tx->type = 'PHUFFY';
//                $tx->date = Carbon::make($tx->forgedAt);
//
//                return $tx;
//            })->concat($rewards)->sortByDesc('date');
        } catch (ErrorException|\Exception $e) {
            report($e);
            $txs = [];
            $aggregate = null;
            $rewardsAggregate = null;
        }
        $view->with([
            'txs' => [],
            'txs_aggregate' => null,
            'rewards_aggregate' => null,
            'stakedAmount' => 0, // humanNumber($this->graphQLService->getUtxosBalance() / 1000000, 2),
        ]);
    }
}
