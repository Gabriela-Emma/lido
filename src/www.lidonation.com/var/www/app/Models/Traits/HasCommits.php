<?php

namespace App\Models\Traits;

use App\Models\Commit;
use App\Models\Repo;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

trait HasCommits
{
    public function commits(): HasManyThrough
    {
        return $this->hasManyThrough(Commit::class, Repo::class, 'model_id', 'repo_id', 'id')
            ->where('model_type', static::class);
    }
}
