<?php

namespace App\Invokables;

use App\Models\User;
use App\Services\CardanoBlockfrostService;

class GetPoolMultiplier
{
    public function __invoke(User $user): float
    {
        $account = app(CardanoBlockfrostService::class)
            ->get("accounts/{$user->wallet_stake_address}", null)->throw()->object();
        $stake = $account->controlled_amount;

        $lovelaces = 1000000;
        $multiplier = 1.0;
        if ($account->pool_id === config('cardano.pool.hash')) {
            $multiplier = match (true) {
                ($stake >= 100 * $lovelaces && $stake < (1000 * $lovelaces)) => 1.10,
                ($stake >= 1000 * $lovelaces && $stake < (8000 * $lovelaces)) => 1.25,
                ($stake >= 8000 * $lovelaces && $stake < (20000 * $lovelaces)) => 1.50,
                ($stake >= 20000 * $lovelaces) => 1.80,
                default => 1.0
            };
        }
        return $multiplier;
    }
}
