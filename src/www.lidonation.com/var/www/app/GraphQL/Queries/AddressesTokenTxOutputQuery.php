<?php

namespace App\GraphQL\Queries;

use Illuminate\Support\Collection;

class AddressesTokenTxOutputQuery
{
    public function __invoke(array|Collection $addresses, string $policyId): string
    {
        $addresses = collect($addresses)->toJson();

        return <<<GQL
  query {
    TokenInOutput_aggregate(where: {policyId: {_eq: "\\\x{$policyId}"}, transactionOutput: {address: {_in: {$addresses}}}}) {
        aggregate {
            sum {
                quantity
            }
            count
        }
    }
    TransactionOutput(where: {tokens: {quantity: {_gte: "1"}, policyId: {_eq: "\\\x{$policyId}"}}, address: {_in: {$addresses}}}, order_by: {transaction: {block: {forgedAt: desc_nulls_last}}}, limit: 20) {
        ...TransactionOutputFragment
    }
  }
  fragment TransactionOutputFragment on TransactionOutput {
      tokens {
        assetName
        policyId
        quantity
      }
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
        }
      }
  }
GQL;
    }
}
