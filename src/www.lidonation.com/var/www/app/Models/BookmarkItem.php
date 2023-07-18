<?php

namespace App\Models;

use App\Models\Traits\HasModel;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class BookmarkItem extends Model
{
    use HasModel, HasFactory, SoftDeletes;

    // public function title(): Attribute
    // {
    //     return Attribute::make(get: fn ($value) => $value ?? $this->model?->title);
    // }

    public function title(): Attribute
    {
        return Attribute::make(set: fn ($value) => $value ?? $this->model?->title);
    }

    public function collection(): BelongsTo
    {
        return $this->belongsTo(BookmarkCollection::class, 'bookmark_collection_id');
    }
}
