<?php

namespace App\GraphQL\Queries;

class PoolActiveDelegationCountQuery
{
    public function __invoke(): string
    {
        $poolHash = config('cardano.pool.hash');

        return <<<GQL
  query {
    stakePools(where: {id: {_eq: "{$poolHash}"}}) {
        id
        activeStake_aggregate(distinct_on: address) {
            aggregate {
                count
            }
        }
    }
  }
GQL;
    }
}
