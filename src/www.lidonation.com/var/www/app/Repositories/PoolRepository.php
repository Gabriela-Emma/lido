<?php

namespace App\Repositories;

use App\Models\Cardano\Block;
use App\Models\Cardano\PoolHash;
use App\Models\Cardano\PoolUpdate;
use App\Models\Cardano\SlotLeader;
use Illuminate\Support\Facades\DB;
use JetBrains\PhpStorm\Pure;

class PoolRepository extends DbSyncRepository
{
    // Constructor to bind model to repo
    #[Pure]
    public function __construct(
        PoolUpdate $model,
        protected PoolHash $poolHash,
        protected Block $block,
        protected SlotLeader $slotLeader
    ) {
        parent::__construct($model);
    }

    // get the record with the given id
    public function get(mixed $idOrSlug, ...$params)
    {
        $model = null;

        try {
            if (is_int($idOrSlug)) {
                $model = $this->model->findOrFail($idOrSlug);
            } else {
                $model = $this->model->where('slug', '=', $idOrSlug)->firstOrFail();
            }
        } catch (\Exception $e) {
            $this->handleException($e);
        }

        return $model;
    }

    public function active()
    {
        $builder = null;
        try {
            $builder = $this->model->active();
        } catch (\Exception $e) {
            $this->handleException($e);
        }

        return $builder;
    }

    public function totalPools(): ?int
    {
        $total = null;
        try {
            $total = $this->active()->count();
        } catch (\Exception $e) {
            $this->handleException($e);
        }

        return $total;
    }

    public function blocks($poolHash = null): ?\Illuminate\Support\Collection
    {
        $query = null;
        try {
            $poolHash = $poolHash ?? config('cardano.hash');
            $db = DB::connection($this->block->getConnectionName());
            $db->getPdo();
            $query = $db
                ->table($this->block->getTable())
                ->join($this->slotLeader->getTable(), 'block.slot_leader_id', '=', 'slot_leader.id')
                ->join($this->poolHash->getTable(), 'slot_leader.pool_hash_id', '=', 'pool_hash.id')
                ->whereRaw(
                    "pool_hash.view = '{$poolHash}'"
                )->from($this->block->getTable())
                ->selectRaw('block.id, block.epoch_no, size, time, block_no');
        } catch (\Exception $e) {
            $this->handleException($e);
        }

        return $query?->get();
    }

    public function delegates($poolHash = null): ?\Illuminate\Support\Collection
    {
        try {
            $poolHash = $poolHash ?? config('cardano.hash');
            $db = DB::connection($this->block->getConnectionName());
            $db->getPdo();
            $query = $db
                ->table($this->block->getTable())
                ->join($this->slotLeader->getTable(), 'block.slot_leader_id', '=', 'slot_leader.id')
                ->join($this->poolHash->getTable(), 'slot_leader.pool_hash_id', '=', 'pool_hash.id')
                ->whereRaw(
                    "pool_hash.view = '{$poolHash}'"
                )->from($this->block->getTable())
                ->selectRaw('block.id, block.epoch_no, size, time, block_no');
        } catch (\Exception $e) {
            $this->handleException($e);
        }

        return $query?->get();
    }
}
