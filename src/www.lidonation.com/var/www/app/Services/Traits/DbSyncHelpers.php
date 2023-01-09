<?php

namespace App\Services\Traits;

use Illuminate\Database\QueryException;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

trait DbSyncHelpers
{
    public function getTxOuts($address): Collection
    {
        return DB::connection(config('database.dbSync'))
            ->table('tx_out')
            ->join('tx', 'tx.id', '=', 'tx_out.tx_id')
            ->where('address', "$address")
            ->get();
    }

    public function getSeedTxFee($seed_tx): int
    {
        $row = DB::connection(config('database.dbSync'))
            ->table('tx')
            ->where('hash', "\x$seed_tx")
            ->first(['id', 'fee']);

        return intval($row->fee);
    }

    public function getStakeUtxoAddresses($stakeAddress): Collection
    {
        try {
            return DB::connection(config('database.dbSync'))
                ->table('utxo_view')
                ->select('address')
                ->join('stake_address', 'stake_address.id', '=', 'utxo_view.stake_address_id')
                ->where('stake_address.view', $stakeAddress)
                ->get()->map(fn ($r) => $r->address);
        } catch (QueryException $err) {
            report($err);
        }

        return  collect();
    }

    /**
     * @throws RequestException
     */
    public function getUserAddresses(string $fromTx = null): object|null
    {
        $fromTx = $fromTx ?? ($this->getSeedTransaction())?->id;

        // find related stake address'
        $senderAddr = DB::connection(config('database.dbSync'))
            ->table('tx_out')
            ->select('*')
            ->join('tx_in', 'tx_out.tx_id', '=', 'tx_in.tx_out_id')
            ->join('tx', function ($join) {
                $join->on('tx.id', '=', 'tx_in.tx_in_id');
                $join->on('tx_in.tx_out_index', '=', 'tx_out.index');
            })
            ->join('stake_address', 'tx_out.stake_address_id', '=', 'stake_address.id')
            ->where('tx.hash', "\x$fromTx")
            ->first();

        if (! $senderAddr) {
            return null;
        }

        $senderAddr->stake_address = $senderAddr?->view;

        return $senderAddr;
    }

    protected function poolRewardsSum($includeSpo = false): int
    {
        $query = DB::connection(config('database.dbSync'))
            ->table('reward')
            ->join('pool_hash', 'reward.pool_id', '=', 'pool_hash.id')
            ->where('pool_hash.view', config('cardano.pool.hash'));

        if ($includeSpo) {
            $query->where('type', 'member');
        }

        return (int) $query->sum('reward.amount');
    }

    protected function getEpochDelegations($epoch): Collection
    {
        $query = DB::connection(config('database.dbSync'))
            ->table('epoch_stake')
            ->select(['epoch_stake.amount', 'epoch_stake.epoch_no', 'stake_address.view as stake_address'])
            ->join('pool_hash', 'epoch_stake.pool_id', '=', 'pool_hash.id')
            ->join('stake_address', 'epoch_stake.addr_id', '=', 'stake_address.id')
            ->where('pool_hash.view', config('cardano.pool.hash'));

        if (isset($epoch)) {
            $query->where([
                'epoch_stake.epoch_no' => $epoch,
            ]);
        }

        return $query->get();
    }

    protected function getPoolHighestDelegation($epoch): int
    {
        $query = DB::connection(config('database.dbSync'))
            ->table('epoch_stake')
            ->select(['epoch_stake.amount', 'epoch_stake.epoch_no', 'stake_address.view as stake_address'])
            ->join('pool_hash', 'epoch_stake.pool_id', '=', 'pool_hash.id')
            ->join('stake_address', 'epoch_stake.addr_id', '=', 'stake_address.id')
            ->where('pool_hash.view', config('cardano.pool.hash'))
            ->where('stake_address.view', '!=', config('cardano.pool.stake_address'));

        if (isset($epoch)) {
            $query->where([
                'epoch_stake.epoch_no' => $epoch,
            ]);
        }

        return (int) $query->orderByDesc('epoch_stake.amount')
            ->first()?->amount;
    }

    protected function getPoolDelegators($epoch = null): Collection
    {
        $delegations = DB::connection(config('database.dbSync'))
            ->table('delegation')
            ->selectRaw('DISTINCT ON (delegation.addr_id) delegation.id as delegation_id, delegation.active_epoch_no, pool_hash."view" as pool_hash, stake_address."view" as stake_address')
            ->join('pool_hash', 'delegation.pool_hash_id', '=', 'pool_hash.id')
            ->join('stake_address', 'delegation.addr_id', '=', 'stake_address.id')
            ->where('pool_hash.view', config('cardano.hash'))
            ->get();

        if (isset($epoch)) {
            return $delegations->filter(
                fn ($delegator) => $this->getStakeDelegations($delegator->stake_address)
                    ->contains(
                        fn ($del) => $del->epoch_no === $epoch)
            );
        }

        return $delegations;
    }

    public function getStakeDelegations($stakeAddress, $limit = null, $poolHash = null): Collection
    {
        $query = DB::connection(config('database.dbSync'))
            ->table('epoch_stake')
            ->select(['pool_hash.view as pool', 'epoch_stake.epoch_no', 'epoch_stake.amount'])
            ->join('stake_address', 'epoch_stake.addr_id', '=', 'stake_address.id')
            ->join('pool_hash', 'epoch_stake.pool_id', '=', 'pool_hash.id')
            ->where('stake_address.view', $stakeAddress)
            ->orderByDesc('epoch_no');

        if (isset($poolHash)) {
            $query->where('pool_hash.view', $poolHash);
        }

        if (isset($limit)) {
            $query->limit($limit);
        }

        return $query->get();
    }

    protected function getCurrentPool($stakeAddress)
    {
        return $this->getStakeDelegations($stakeAddress, 5)
            ->first();
    }

    protected function activeOnEpoch($stakeAddress): int
    {
        return (int) DB::connection(config('database.dbSync'))
            ->table('delegation')
            ->select('active_epoch_no')
            ->join('stake_address', 'delegation.addr_id', '=', 'stake_address.id')
            ->join('pool_hash', 'delegation.pool_hash_id', '=', 'pool_hash.id')
            ->where('stake_address.view', $stakeAddress)
            ->where('pool_hash.view', config('cardano.hash'))
            ->first()->active_epoch_no;
    }

    protected function cardanoStakedAddresses(): int
    {
        return (int) DB::connection(config('database.dbSync'))
            ->query()
            ->fromSub(function ($query) {
                $query
                    ->from('delegation')
                    ->selectRaw('DISTINCT ON (delegation.addr_id) delegation.addr_id');
            }, 'a')->count();
    }
}
