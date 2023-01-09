<?php

namespace App\GraphQL\Queries;

use Illuminate\Support\Collection;

class AddressesTxOutputQuery
{
    public function __invoke(array|Collection $addresses): string
    {
        $addresses = collect($addresses)->toJson();

        return <<<GQL
  query {
    utxos_aggregate(where: {address: {_in: {$addresses}}}) {
        aggregate {
            count
            sum {
                value
            }
        }
    }
    utxos(where: {address: {_in: {$addresses}}}) {
        value
        transaction {
            metadata {
              key
              value
            }
            block {
              forgedAt
              epochNo
              slotNo
              number
            }
        }
    }
  }
GQL;
    }
}
