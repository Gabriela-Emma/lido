<?php

namespace App\Models;

use Illuminate\Support\Str;
use App\Scopes\OrderByDateScope;
use App\Models\Traits\HasMetaData;
use Illuminate\Support\Collection;
use App\Models\Reactions\HasReactions;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Comments\Models\Concerns\HasComments;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CatalystReport extends Model
{
    use SoftDeletes, HasReactions, HasMetaData, HasComments;

    protected $withCount = [
        'comments',
        'hearts',
        'eyes',
        'party_popper',
        'rocket',
        'thumbs_down',
        'thumbs_up'
    ];

    public function getExcerptAttribute($value): string
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
     */
    protected static function booted(): void
    {
        parent::booted();
        static::addGlobalScope(new OrderByDateScope);
    }

    public function commentableName(): string
    {
        return 'Catalyst Report for: '.$this->proposal?->title;
    }

    public function commentUrl(): string
    {
        return url('/catalyst-explorer/reports#'.$this->id);
    }
}
