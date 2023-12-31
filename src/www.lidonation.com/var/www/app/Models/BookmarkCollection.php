<?php

namespace App\Models;

use App\Http\Traits\HasHashIds;
use App\Models\CatalystExplorer\Proposal;
use App\Models\Traits\HasAuthor;
use App\Models\Traits\HashIdModel;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Parental\HasChildren;
use Vinkla\Hashids\Facades\Hashids;

class BookmarkCollection extends Model
{
    use HasAuthor, HasChildren, HasHashIds, HashIdModel, SoftDeletes;

    protected $with = [
        // 'items',
        'rationales.metas'
    ];

    protected $hidden = ['id'];

    protected $withCount = [
        'items'
    ];

    protected $appends = [
        'link', 'hash'
    ];

    protected $fillable = ['title', 'content', 'type'];

    protected $urlGroup = 'catalyst-explorer/bookmarks';

    public function bookmarkCollectionId(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Hashids::connection(static::class)->encode($value)
        );
    }

    public function items(): HasMany
    {
        return $this->hasMany(BookmarkItem::class);
    }

    public function proposals(): HasMany
    {
        return $this->hasMany(BookmarkItem::class)
            ->where('model_type', Proposal::class);
    }

    public function rationales(): HasMany
    {
        return $this->hasMany(Discussion::class, 'model_id')
            ->where('model_type', BookmarkCollection::class);
    }
}
