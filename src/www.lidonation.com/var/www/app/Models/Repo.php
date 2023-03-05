<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Repo extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    protected $withCount = [];

    protected $with = [];

    public function commits(): HasMany
    {
        return $this->HasMany(Commit::class, 'repo_id');
    }
}
