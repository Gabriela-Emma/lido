<?php

namespace App\Models;


use App\Models\Traits\HasAuthor;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BookmarkCollection extends Model
{
    use HasAuthor;

    protected $with = ['items'];

    protected $withCount = ['items'];

    public function items(): HasMany
    {
        return $this->hasMany(BookmarkItem::class);
    }
}
