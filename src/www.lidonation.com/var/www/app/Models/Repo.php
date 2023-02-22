<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;

class Repo extends Model
{

    protected $guarded = [];

    protected $withCount = [];

    protected $with = [];

    public function commits(): HasMany
    {
        return $this->HasMany(Commit::class, 'repo_id');
    }
}
