<?php

namespace App\GraphQL\Queries;

class PoolDelegationRewardsSumQuery
{
    public function __invoke(): string
    {
        $poolHash = config('cardano.pool.hash');

        return <<<GQL
  query {
    rewards_aggregate(where: {stakePool: {id: {_eq: "{$poolHash}"}}, type: {_eq: "member"}}) {
        aggregate {
          sum {
            amount
          }
        }
    }
  }
GQL;
    }
}
