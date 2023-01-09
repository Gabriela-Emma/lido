<?php

namespace App\GraphQL\Queries;

class StakeDelegationQuery
{
    public function __invoke(string $stakeAddress, int $epoch): string
    {
        return <<<GQL
  query {
    activeStake(where: {address: {_eq: "{$stakeAddress}"}, epochNo: {_eq: "{$epoch}"}}) {
        amount
        epochNo
    }
  }
GQL;
    }
}
