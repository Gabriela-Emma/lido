<?php

namespace App\GraphQL\Queries;

class StakedAddressesCountQuery
{
    public function __invoke(): string
    {
        return <<<'GQL'
   query {
        activeStake_aggregate(distinct_on: address) {
            aggregate {
                count
            }
        }
   }
GQL;
    }
}
