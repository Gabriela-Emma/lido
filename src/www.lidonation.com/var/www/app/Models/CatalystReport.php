<?php

namespace App\Models;

use App\Models\Traits\HasMetaData;
use App\Scopes\OrderByDateScope;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class CatalystReport extends Model
{
    use SoftDeletes, HasMetaData;

    public function getExcerptAttribute($value)
    {
        if (isset($value)) {
            return $value;
        }

        return Str::words($this->content, 80);
    }

    public function getAttachmentsAttribute(): ?Collection
    {
        if (empty($this->attachment)) {
            return collect(null);
        }

        return collect(explode(',', Str::remove(' ', $this->attachment)));
    }

    public function proposal(): BelongsTo
    {
        return $this->belongsTo(Proposal::class);
    }

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted(): void
    {
        parent::booted();
        static::addGlobalScope(new OrderByDateScope);
    }
}
