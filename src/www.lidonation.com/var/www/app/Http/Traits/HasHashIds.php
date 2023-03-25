<?php

namespace App\Http\Traits;

use App\Models\BookmarkCollection;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Vinkla\Hashids\Facades\Hashids;

trait HasHashIds
{
    /**
     * Get Model by hashed key.
     *
     * @param Builder $query
     * @param string|null $hash
     *
     * @return Builder
     */
    public function scopeByHash(Builder $query, ?string $hash): Builder
    {
        return  $query->where('id', Hashids::connection(static::class)->decode($hash));
    }

    /**
     * Get Model by hashed key.
     *
     * @param Builder $query
     * @param array $hashes
     *
     * @return Builder
     */
    public function scopeWhereHashIn(Builder $query, array $hashes = []): Builder
    {
        return  $query->whereIn('id', collect($hashes)->map( fn($hash) => Hashids::connection(static::class)->decode($hash)));
    }

    /**
     * Get Model by hash.
     *
     * @param $hash
     *
     * @return HasHashIds|BookmarkCollection|null
     */
    public static function byHash($hash): ?self
    {
        return self::query()->byHash($hash)->first();
    }

    /**
     * Get Model by hash.
     *
     * @param array $hashes
     * @return Collection
     */
    public static function whereHashIn(array $hashes): Collection
    {
        return self::query()->whereHashIn($hashes)->get();
    }

    /**
     * Get model by hash or fail.
     *
     * @param $hash
     *
     * @return HasHashIds|BookmarkCollection
     *
     * @throw \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public static function byHashOrFail($hash): self
    {
        return self::query()->byHash($hash)->firstOrFail();
    }

    public function getRouteKey(): string
    {
        return Hashids::connection(get_called_class())->encode($this->getKey());
    }
}
