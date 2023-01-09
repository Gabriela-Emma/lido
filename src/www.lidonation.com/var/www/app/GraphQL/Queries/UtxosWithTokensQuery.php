<?php

namespace App\GraphQL\Queries;

use Illuminate\Support\Collection;

class UtxosWithTokensQuery
{
    public function __invoke(array|Collection $addresses, string $policyId): string
    {
        $addresses = collect($addresses)->toJson();

        return <<<GQL
    query {
        utxos(where: {tokens: {policyId: {_eq: "\\\x{$policyId}"}}, address: {_in: {$addresses}}}) {
            tokens {
                assetId
                policyId
                quantity
                assetName
                transactionOutput {
                    transaction {
                        metadata {
                            key
                            value
                        }
                        block {
                            forgedAt
                            epochNo
                            slotNo
                        }
                    }
                }
            }
            value
        }
        utxos_aggregate(where: {tokens: {policyId: {_eq: "\\\x{$policyId}"}}, address: {_in: {$addresses}}}) {
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
