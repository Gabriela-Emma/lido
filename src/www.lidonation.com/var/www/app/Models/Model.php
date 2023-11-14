<?php

namespace App\Models;

use App\Traits\HasRemovableGlobalScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model as EloquentModel;

class Model extends EloquentModel
{
    use HasFactory, HasRemovableGlobalScopes;

    public function scopeNoEagerLoads($query)
    {
        return $query->setEagerLoads([]);
    }
}
