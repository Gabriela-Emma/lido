<?php

namespace App\Scopes;

use App\Models\Cardano\PoolUpdate;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class GroupPoolUpdatesScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @return void
     */
    public function apply(Builder $builder, PoolUpdate|Model $model)
    {
        $builder->distinct('hash_id');
    }
}
