<?php

namespace App\GraphQL\Queries;

class TokenMintQuery
{
    public function __invoke(string $policyId): string
    {
        return <<<GQL
  query {
    tokenMints_aggregate(where: {policyId: {_eq: "\\\x{$policyId}"}}) {
        aggregate {
            count
            sum {
                quantity
            }
        }
    }
    tokenMints(where: {policyId: {_eq: "\\\x{$policyId}"}}) {
        assetId
        policyId
        quantity
        tx_id
        transaction {
            outputs {
                address
                value
                transaction {
                    metadata {
                        key
                        value
                    }
                    block {
                        epochNo
                        forgedAt
                        slotNo
                    }
                }
            }
            block {
                forgedAt
            }
        }
    }
  }
GQL;
    }
}
