<?php

namespace App\GraphQL\Queries;

class StakePoolCountQuery
{
    public function __invoke(): string
    {
        return <<<'GQL'
   query {
        stakePools_aggregate(where: {pledge: {_gt: "5"}, activeStake: {amount: {_gt: "5"}}}, distinct_on: hash) {
            aggregate {
                count
            }
        }
   }
GQL;
    }
}
