<?php

namespace App\Services;

use App\Http\Integrations\Lucid\Requests\GetWalletBalancesRequest;
use Illuminate\Support\Collection;

class LucidService
{
    public function getWalletBalances(string $seed): Collection
    {
        $request = new GetWalletBalancesRequest($seed);
        $response = $request->send();

        return $response->collect();
    }
}
