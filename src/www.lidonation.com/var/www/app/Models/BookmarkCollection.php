<?php

namespace App\Models;


use App\Http\Traits\HasHashIds;
use App\Models\Traits\HasAuthor;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Vinkla\Hashids\Facades\Hashids;

class BookmarkCollection extends Model
{
    use HasAuthor, HasHashIds;

    protected $hidden = ['id'];

    protected $with = ['items'];

    protected $withCount = ['items'];

    protected $appends = ['link', 'hash'];

    public function hash(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Hashids::connection(static::class)->encode($this->id)
        );
    }


    public function bookmarkCollectionId(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Hashids::connection(static::class)->encode($value)
        );
    }

    public function rawId(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->getRawOriginal('id')
        );
    }

    public function link(): Attribute
    {
        return Attribute::make(
            get: fn() =>  LaravelLocalization::localizeURL("/catalyst-explorer/bookmarks/{$this->hash}/")
        );
    }

    public function items(): HasMany
    {
        return $this->hasMany(BookmarkItem::class);
    }
}
