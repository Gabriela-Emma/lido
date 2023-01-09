<?php

namespace App\GraphQL\Queries;

class StakeRewardsQuery
{
    public function __invoke(string $stakeAddress): string
    {
        return <<<GQL
  query {
    rewards_aggregate(where: {address: {_eq: "{$stakeAddress}"}}) {
        aggregate {
            sum {
                amount
            }
        }
    }
    rewards(limit: 10, where: {address: {_eq: "{$stakeAddress}"}}, order_by: {receivedInEpochNo: desc_nulls_last}) {
        address
        amount
        earnedInEpochNo
        receivedInEpochNo
        receivedIn {
            startedAt
        }
    }
  }
GQL;
    }
}
