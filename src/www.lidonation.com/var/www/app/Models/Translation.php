<?php

namespace App\Models;

use App\Models\Traits\HasAuthor;
use App\Models\Traits\HasMetaData;
use App\Traits\HasRemovableGlobalScopes;
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class Translation extends Model
{
    use HasAuthor,
        HasTimestamps,
        SoftDeletes,
        HasRemovableGlobalScopes,
        HasMetaData;

    protected $guarded = ['user_id', 'created_at', 'published_at'];

    protected $casts = [
        'updated_at' => 'datetime:Y-m-d',
        'published_at' => 'datetime:Y-m-d',
    ];

    public function getTypeNameAttribute()
    {
        return Str::plural(class_basename($this));
    }

    public function getPublishedAtFormattedAttribute()
    {
        return $this->published_at->formatLocalized('%b %d %Y');
    }

    public function getUpdatedAtFormattedAttribute()
    {
        return $this->updated_at->formatLocalized('%b %d %Y');
    }

    public function scopeSourceType($query, $type)   // e.g. 'App\Models\Translation'
    {
        return $query->where('source_type', $type);
    }

    public function scopeSourceField($query, $type)   // e.g. 'App\Models\Translation'
    {
        return $query->where('source_field', $type);
    }

    public function scopeMyTranslations($query)
    {
        $query->where('user_id', Auth::user()->getAuthIdentifier());
    }

    public function scopeMissingTranslation($query)
    {
        $query->where('content', '')
            ->orWhereNull('content');
    }

    public function source(): MorphTo
    {
        return $this->morphTo('source', 'source_type', 'source_id');
    }

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        parent::booted();
//        static::addGlobalScope(new PublishedScope);
    }
}
