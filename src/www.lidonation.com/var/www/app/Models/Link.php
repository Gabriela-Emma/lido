<?php

namespace App\Models;

use App\Scopes\IsValidScope;
use App\Scopes\OrderByOrderScope;
use App\Scopes\PublishedScope;
use App\Traits\SearchableLocale;
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Artisan;

/**
 * to index run php artisan ln:index 'App\Models\Link' ln__links 'type,link,label,title,status,valid'
 */
class Link extends Model
{
    use HasFactory, HasTimestamps, SearchableLocale, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['link', 'status', 'label', 'title', 'valid'];

    public static function runCustomIndex()
    {
        Artisan::call('ln:index App\\\\Models\\\\Link ln__links');
    }

    public function model(): MorphTo
    {
        return $this->morphTo('model_link', 'model_type', 'model_id');
    }

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        parent::booted();
        static::addGlobalScope(new IsValidScope);
        static::addGlobalScope(new PublishedScope);
        static::addGlobalScope(new OrderByOrderScope);
    }
}
