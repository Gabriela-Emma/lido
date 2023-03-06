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
                ($stake >= 100 * $lovelaces && $stake < (1000 * $lovelaces)) => 1.15,
                ($stake >= 1000 * $lovelaces && $stake < (8000 * $lovelaces)) => 1.30,
                ($stake >= 8000 * $lovelaces && $stake < (20000 * $lovelaces)) => 1.55,
                ($stake >= 20000 * $lovelaces) => 1.85,
                ($stake >= 30000 * $lovelaces) => 2,
                ($stake >= 50000 * $lovelaces) => 2.25,
                ($stake >= 75000 * $lovelaces) => 2.50,
                ($stake >= 100000 * $lovelaces) => 3,
                default => 1.0
            };
        }

        return $multiplier;
    }
}
