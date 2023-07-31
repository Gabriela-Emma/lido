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
        return Attribute::make(set: fn ($value) => $this->model?->title);
    }

    public function collection(): BelongsTo
    {
        return $this->belongsTo(BookmarkCollection::class, 'bookmark_collection_id');

        $b = BookmarkItem::cursor();
        foreach ($b as $item) {
            $item->title = $item->model?->title;
            $item->save();
        }
        Withdrawal::withCount('rewards')
        ->whereHas('rewards', fn($q) => $q->where('asset_type', 'ft'))
        ->where('status', 'pending')->get()
        ->filter(fn($w) => $w->rewards_count < 5)
        ->each(function($w){
            Reward::where('withdrawal_id', $w->id)->each(function($r) {
                $r->withdrawal_id = null; $r->status = 'issued'; $r->save();
            });
        });
    }
}
