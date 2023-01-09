<?php

namespace App\GraphQL\Queries;

use Illuminate\Support\Collection;

class UtxosBalanceQuery
{
    public function __invoke(array|Collection $addresses): string
    {
        $addresses = collect($addresses)->toJson();

        return <<<GQL
    query {
        utxos_aggregate(where: {address: {_in: {$addresses}}}) {
            aggregate {
                sum {
                    value
                }
            }
        }
    }
GQL;
    }
}
