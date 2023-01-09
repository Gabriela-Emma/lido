<?php

namespace App\Services;

use App\GraphQL\Queries\AddressesTokenTxOutputQuery;
use App\GraphQL\Queries\AddressesTxOutputQuery;
use App\GraphQL\Queries\PoolActiveDelegationCountQuery;
use App\GraphQL\Queries\PoolActiveStakeQuery;
use App\GraphQL\Queries\PoolDelegationRewardsSumQuery;
use App\GraphQL\Queries\StakedAddressesCountQuery;
use App\GraphQL\Queries\StakeDelegationQuery;
use App\GraphQL\Queries\StakePoolCountQuery;
use App\GraphQL\Queries\StakeRewardsQuery;
use App\GraphQL\Queries\TokenMintQuery;
use App\GraphQL\Queries\UtxosBalanceQuery;
use App\GraphQL\Queries\UtxosWithTokensQuery;
use App\Models\User;
use App\Repositories\EpochRepository;
use App\Services\Traits\DbSyncHelpers;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Fluent;

class CardanoGraphQLService
{
    use DbSyncHelpers;

    public function __construct(
        protected ?string $endPoint = null,
    ) {
        $this->endPoint = $this->endPoint ?? config('cardano.graphQLEndpoint');
    }

    /**
     * @throws GuzzleException
     */
    public function getStakeTransactions(): void
    {
        try {
            $query = (new StakePoolCountQuery);
            $client = new Client();

            $response = $client->request('POST', $this->endPoint, [
                'headers' => [
                    // include any auth tokens here
                ],
                'json' => [
                    'query' => $query,
                ],
            ]);
        } catch (ConnectException $e) {
            report($e);
        }
    }

    /**
     * @throws GuzzleException
     */
    public function getPoolDelegationCount(): ?int
    {
        $query = (new PoolActiveDelegationCountQuery)();
        $body = $this->getResponse($query);
        $stakePools = $body?->data?->stakePools ?? null;
        if (is_array($stakePools) && ! empty($stakePools)) {
            $data = $stakePools[0];

            return $data?->activeStake_aggregate?->aggregate?->count ?? null;
        }

        return null;
    }

    /**
     * @throws GuzzleException
     */
    public function getStakePoolCount($useCache = true): ?int
    {
        if ($useCache) {
            $value = Cache::get('StakePoolCountQuery', null);
            if ($value) {
                return $value;
            }
        }
        $query = (new StakePoolCountQuery)();
        $body = $this->getResponse($query);
        $value = $body?->data?->stakePools_aggregate?->aggregate?->count ?? null;
        if ($value) {
            Cache::put('StakePoolCountQuery', $value, now()->addHours(3));
        }

        return $value;
    }

    /**
     * @throws GuzzleException
     */
    public function getStakedAddressesCount($useCache = true): ?int
    {
        if ($useCache) {
            $value = Cache::get('StakedAddressesCountQuery', null);
            if ($value) {
                return $value;
            }
        }
        $query = (new StakedAddressesCountQuery)();
        $body = $this->getResponse($query);
        $value = $body?->data?->activeStake_aggregate?->aggregate?->count ?? null;
        if ($value) {
            Cache::put('StakedAddressesCountQuery', $value, now()->addHours(3));
        }

        return $value;
    }

    /**
     * @throws GuzzleException
     */
    public function getPoolDelegationRewardsSum($useCache = true): int|string|null
    {
        if ($useCache) {
            $sum = Cache::get('PoolDelegationRewardsSumQuery', null);
            if ($sum) {
                return $sum;
            }
        }
        $query = (new PoolDelegationRewardsSumQuery)();
        $body = $this->getResponse($query);
        $sum = $body?->data?->rewards_aggregate?->aggregate?->sum?->amount ?? null;
        if ((bool) $sum) {
            $sum = humanNumber($sum / 1000000, 2);
            Cache::put('PoolDelegationRewardsSumQuery', $sum, now()->addHours(3));
        }

        return $sum;
    }

    /**
     * @throws GuzzleException
     */
    public function getPoolActiveState($useCache = true): int|string|null
    {
        if ($useCache) {
            $sum = Cache::get('PoolActiveStakeQuery', null);
            if ($sum) {
                return $sum;
            }
        }
        $query = (new PoolActiveStakeQuery)();
        $body = $this->getResponse($query);
        $sum = $body?->data?->activeStake_aggregate?->aggregate?->sum?->amount ?? null;
        if ((bool) $sum) {
            $sum = humanNumber($sum / 1000000, 2);
            Cache::put('PoolActiveStakeQuery', $sum, now()->addHours(3));
        }

        return $sum;
    }

    /**
     * @throws GuzzleException
     */
    public function getStakeDelegation(User $user = null, int $epoch = null): int|string|null
    {
        $user = $user ?? auth()->user();
        $epochNo = $epoch ?? app(EpochRepository::class)->current()?->no;
        $query = (new StakeDelegationQuery)($user->wallet_stake_address, $epochNo);
        $body = $this->getResponse($query);
        $delegations = collect($body?->data?->activeStake ?? []);
        $amount = $delegations->first()?->amount ?? null;
        if ((bool) $amount) {
            return humanNumber($amount / 1000000, 2);
        }

        return null;
    }

    /**
     * getPolicyMints
     * User $user User whose wallet to check. Defaults to currently authenticated
     * string $policyId token to limit to. Defaults to PHUFFY.
     *
     * @throws GuzzleException
     */
    public function getPolicyMints(?string $policyId = null, $withAggregate = false): Collection|array
    {
        $policyId = $policyId ?? config('cardano.mint.policies.phuffycoin');
        $query = (new TokenMintQuery)($policyId);
        $body = $this->getResponse($query);
        $mints = collect($body?->data?->tokenMints ?? []);
        if ($mints->isNotEmpty()) {
            $mints = $mints->map(function ($m) {
                $m->date = Carbon::make($m?->transaction?->block?->forgedAt);

                return $m;
            });
        }

        if (! $withAggregate) {
            return $mints;
        }
        // get aggregate
        $aggregate = $body?->data?->tokenMints_aggregate?->aggregate ?? null;

        return [$mints, $aggregate];
    }

    /**
     * getStakingRewardTxs
     * User $user User whose wallet to check. Defaults to currently authenticated
     * string $policyId token to limit to. Defaults to PHUFFY.
     *
     * @throws GuzzleException
     */
    public function getStakingRewardTxs(?User $user = null, $withAggregate = false): Collection|array|null
    {
        $user = $user ?? auth()->user();
        if (! $user?->wallet_stake_address) {
            return null;
        }
        $query = (new StakeRewardsQuery)($user->wallet_stake_address);
        $body = $this->getResponse($query);
        $txs = collect($body?->data?->rewards ?? []);
        if ($txs->isNotEmpty()) {
            $txs = $txs->map(function ($tx) {
                $tx->date = Carbon::make($tx?->receivedIn?->startedAt);

                return $tx;
            });
        }

        if (! $withAggregate) {
            return $txs;
        }
        // get aggregate
        $aggregate = $body?->data?->rewards_aggregate?->aggregate ?? null;

        return [$txs, $aggregate];
    }

    /**
     * getUtxosBalance
     *
     * returns utxos for address list pass. If none is passed,
     * defaults to passed user's addresses associated with their stake key.
     * array $addresses array of addresses to query against
     * User $user User whose wallet to check. Defaults to currently authenticated
     *
     * @throws GuzzleException
     */
    public function getUtxosBalance(array $addresses = null, ?User $user = null): int
    {
        if (! is_array($addresses)) {
            $user = $user ?? auth()->user();
            if (! $user) {
                return 0;
            }
            $addresses = $this->getStakeUtxoAddresses($user->wallet_stake_address);
        }
        $query = (new UtxosBalanceQuery)($addresses);
        $body = $this->getResponse($query);

        return $body?->data?->utxos_aggregate?->aggregate?->sum?->value ?? 0;
    }

    /**
     * getAddressTxs
     * User $user User whose wallet to check. Defaults to currently authenticated
     * string $policyId token to limit to. Defaults to PHUFFY.
     *
     * @throws GuzzleException
     */
    public function getAddressTxs(array $addresses = null, ?User $user = null, $withAggregate = false): Collection|array
    {
        if (! is_array($addresses)) {
            $user = $user ?? auth()->user();
            $addresses = $this->getStakeUtxoAddresses($user->wallet_stake_address);
        }

        $query = (new AddressesTxOutputQuery)($addresses);
        $body = $this->getResponse($query);
        $txs = collect($body?->data?->utxos ?? []);
        if ($txs->isNotEmpty()) {
            $txs = $txs->map(function ($tx) {
                $transaction = [
                    'quantity' => (int) $tx?->value,
                    'date' => Carbon::make($tx?->transaction?->block?->forgedAt),
                    'epochNo' => (int) $tx?->transaction?->block?->epochNo,
                    'slotNo' => (int) $tx?->transaction?->block?->slotNo,
                    'blockNo' => (int) $tx?->transaction?->block?->number,
                    'metadata' => null,
                ];
                // parse metadata
                if (isset($tx?->transaction?->metadata)) {
                    $metadata = collect($tx?->transaction?->metadata);
                    if ($metadata->isNotEmpty()) {
                        $metadata = $metadata->map(function ($m) {
                            if (isset($m?->value?->map)) {
                                $mapToCollection = collect($m?->value?->map);
                                $keys = $mapToCollection->pluck('k.string');
                                $values = $mapToCollection->pluck('v.string');
                                $mapToCollection = $keys->combine($values);

                                return $mapToCollection->toArray();
                            }

                            return null;
                        });
                        $transaction['metadata'] = new Fluent($metadata->collapse()->toArray());
                    }
                }

                return new Fluent($transaction);
            });
        }

        if (! $withAggregate) {
            return $txs;
        }
        // get aggregate
        $aggregate = $body?->data?->utxos_aggregate?->aggregate ?? null;

        return [$txs, $aggregate];
    }

    /**
     * getAddressesTokenUtxos
     * User $user User whose wallet to check. Defaults to currently authenticated
     * string $policyId token to limit to. Defaults to PHUFFY.
     *
     * @throws GuzzleException
     */
    public function getAddressesTokenUtxos(string $policyId, array $addresses = null, ?User $user = null, $withAggregate = false): Collection|array
    {
        if (! is_array($addresses)) {
            // get all address
            $user = $user ?? auth()->user();
            $addresses = $this->getStakeUtxoAddresses($user?->wallet_stake_address);
        }

        $query = (new UtxosWithTokensQuery)($addresses, $policyId);
        $body = $this->getResponse($query);
        $txs = collect($body?->data?->utxos ?? []);

        if ($txs->isNotEmpty()) {
            $txs = $txs->map(function ($tx) {
                $tx = $tx?->tokens[0];
                $transaction = [
                    'quantity' => $tx?->quantity,
                    'quantityFormatted' => humanNumber($tx?->quantity),
                    'forgedAt' => Carbon::make($tx?->transactionOutput?->transaction?->block?->forgedAt),
                    'date' => Carbon::make($tx?->transactionOutput?->transaction?->block?->forgedAt),
                    'epochNo' => (int) $tx?->transactionOutput?->transaction?->block?->epochNo,
                    'slotNo' => (int) $tx?->transactionOutput?->transaction?->block?->slotNo,
                    'metadata' => null,
                ];

                // parse metadata
                if (isset($tx?->transactionOutput?->transaction?->metadata)) {
                    $metadata = collect($tx?->transactionOutput?->transaction?->metadata);
                    if ($metadata->isNotEmpty()) {
                        $metadata = $metadata->map(function ($m) {
                            if (isset($m?->value?->map)) {
                                $mapToCollection = collect($m?->value?->map);
                                $keys = $mapToCollection->pluck('k.string');
                                $values = $mapToCollection->pluck('v.string');
                                $mapToCollection = $keys->combine($values);

                                return $mapToCollection->toArray();
                            }

                            return null;
                        });
                        $transaction['metadata'] = new Fluent($metadata->collapse()->toArray());
                    }
                }

                return new Fluent($transaction);
            });
        }

        if (! $withAggregate) {
            return $txs;
        }

        return collect($body?->data?->utxos ?? []);
    }

    /**
     * getStakeAddressTokenTxs
     * User $user User whose wallet to check. Defaults to currently authenticated
     * string $policyId token to limit to. Defaults to PHUFFY.
     *
     * @throws GuzzleException
     */
    public function getStakeAddressTokenTxs(?User $user = null, ?string $policyId = null, $withAggregate = false): Collection|array
    {
        $user = $user ?? auth()->user();
        $policyId = $policyId ?? config('cardano.mint.policies.phuffycoin');
        $addresses = $this->getStakeUtxoAddresses($user?->wallet_stake_address);

        $query = (new AddressesTokenTxOutputQuery)($addresses, $policyId);
        $body = $this->getResponse($query);
        $txs = collect($body?->data?->TransactionOutput ?? []);
        if ($txs->isNotEmpty()) {
            $txs = $txs->map(function ($tx) {
                $transaction = [
                    'quantity' => $tx?->tokens[0]?->quantity,
                    'quantityFormatted' => humanNumber($tx?->tokens[0]?->quantity),
                    'forgedAt' => Carbon::make($tx?->transaction?->block?->forgedAt),
                    'epochNo' => (int) $tx?->transaction?->block?->epochNo,
                    'slotNo' => (int) $tx?->transaction?->block?->slotNo,
                    'metadata' => null,
                ];
                // parse metadata
                if (isset($tx?->transaction?->metadata)) {
                    $metadata = collect($tx?->transaction?->metadata);
                    if ($metadata->isNotEmpty()) {
                        $metadata = $metadata->map(function ($m) {
                            if (isset($m?->value?->map)) {
                                $mapToCollection = collect($m?->value?->map);
                                $keys = $mapToCollection->pluck('k.string');
                                $values = $mapToCollection->pluck('v.string');
                                $mapToCollection = $keys->combine($values);

                                return $mapToCollection->toArray();
                            }

                            return null;
                        });
                        $transaction['metadata'] = new Fluent($metadata->collapse()->toArray());
                    }
                }

                return new Fluent($transaction);
            });
        }

        if (! $withAggregate) {
            return $txs;
        }
        // get aggregate
        $aggregate = $body?->data?->TokenInOutput_aggregate?->aggregate ?? null;

        return [$txs, $aggregate];
    }

    /**
     * @throws GuzzleException
     */
    protected function getResponse(string $query)
    {
        try {
            $client = new Client();
            $response = $client->request('POST', $this->endPoint, [
                'headers' => [
                    // include any auth tokens here
                ],
                'json' => [
                    'query' => $query,
                ],
            ]);

            $json = $response->getBody()->getContents();

            return json_decode($json);
        } catch (ConnectException $e) {
            report($e);
        }

        return null;
    }
}
