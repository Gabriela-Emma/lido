<?php

namespace App\GraphQL\Queries;

use App\Repositories\EpochRepository;

class PoolActiveStakeQuery
{
    public function __invoke(): string
    {
        $epochs = app(EpochRepository::class);
        $currEpochNo = $epochs->current()?->no;
        $poolHash = config('cardano.pool.hash');

        return <<<GQL
  query {
    activeStake_aggregate(where: {epochNo: {_eq: "{$currEpochNo}"}, stakePoolId: {_eq: "{$poolHash}"}}, distinct_on: address) {
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
