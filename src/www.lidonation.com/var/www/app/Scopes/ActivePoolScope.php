<?php

namespace App\Scopes;

use App\Models\Cardano\PoolRetire;
use App\Models\Cardano\PoolUpdate;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\QueryException;

class ActivePoolScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @return void
     */
    public function apply(Builder $builder, PoolUpdate|Model $model)
    {
        try {
            dd(
                $builder
                    ->whereIn(
                        'registered_tx_id',
                        fn (\Illuminate\Database\Query\Builder $b) => $b->max('registered_tx_id')
                            ->groupBy('hash_id')
                    )
            );
        } catch (QueryException $exception) {
            dd($exception);
        }
//        $retirements = PoolRetire::get(['hash_id'])->pluck('hash_id');
//        $builder
//            ->whereIn(
//                'registered_tx_id',
//                fn(\Illuminate\Database\Query\Builder $b) => $b->max('registered_tx_id')
//                    ->groupBy('hash_id')
//            );
//        ->whereNotIn('hash_id', $retirements);
    }
}
