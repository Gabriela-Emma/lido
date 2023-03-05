<?php

namespace App\Models\Cardano;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @method active() scope to active pools
 */
class PoolUpdate extends DbSyncModel
{
    use HasFactory;

    protected $table = 'pool_update';

    protected $with = ['hash'];

    protected $casts = [
        'pledge' => 'integer',
        //        'margin' => 'percent'
    ];

    /**
     * Scope a query to only include active users.
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query
            ->whereIn(
                'pool_update.registered_tx_id',
                function (\Illuminate\Database\Query\Builder $builder) {
                    $builder->selectRaw('max(pool_update.registered_tx_id)')
                        ->from($this->table)
                        ->groupBy('hash_id');
                }

            )->whereNotExists(function (\Illuminate\Database\Query\Builder $builder) {
                $builder->from(app(PoolRetire::class)->getTable())
                    ->whereRaw(
                        app(PoolRetire::class)->getTable().'.hash_id = '.$this->getTable().'.hash_id'
                    )->where(app(PoolRetire::class)->getTable().'.retiring_epoch', '<=', function (\Illuminate\Database\Query\Builder $builder) {
                        $builder->selectRaw('max (epoch_no)')
                            ->from(app(Block::class)
                                ->getTable());
                    });
            });
    }

    // Relationships

    public function registerTransaction(): BelongsTo
    {
        return $this->belongsTo(Transaction::class, 'registered_tx_id');
    }

    public function meta(): BelongsTo
    {
        return $this->belongsTo(PoolMeta::class, 'meta_id');
    }

    public function hash(): BelongsTo
    {
        return $this->belongsTo(PoolHash::class, 'hash_id');
    }

    public function relays(): HasMany
    {
        return $this->hasMany(PoolRelay::class, 'update_id');
    }
}
