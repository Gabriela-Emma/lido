<?php

namespace App\Models;

use App\Models\Traits\HasModel;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BookmarkItem extends Model
{
    use HasModel, HasFactory;

    public function title(): Attribute
    {
        return Attribute::make(get: fn ($value) => $value ?? $this->model?->title);
    }

    public function collection(): BelongsTo
    {
        return $this->belongsTo(BookmarkCollection::class);
    }
}
