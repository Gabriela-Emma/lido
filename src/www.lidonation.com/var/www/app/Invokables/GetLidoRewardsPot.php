<?php

namespace App\Invokables;

use App\Models\EveryEpoch;
use App\Services\CardanoBlockfrostService;
use Illuminate\Support\Collection;

class GetLidoRewardsPot
{
    public function __invoke(?EveryEpoch $everyEpoch): Collection
    {
        return $everyEpoch
            ?->giveaway?->balances
            ?->filter(fn ($bal) => $bal['name'] !== 'lovelace')->map(function ($balance) {
                $detail = app(CardanoBlockfrostService::class)
                    ->get("assets/{$balance['asset']}/", null)
                    ->object();
                $balance['decimal'] = $detail->metadata?->decimals;
                if ($balance['decimal'] > 0) {
                    $balance['divisibility'] = intval(str_pad(1, $balance['decimal'] + 1, '0'));
                } else {
                    $balance['divisibility'] = 1;
                }

                return $balance;
            }) ?? collect([]);
    }
}
