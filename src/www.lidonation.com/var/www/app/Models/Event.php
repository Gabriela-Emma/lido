<?php

namespace App\Models;

use App\Models\Interfaces\IHasMetaData;
use App\Models\Traits\HasAssessments;
use App\Models\Traits\HasAuthor;
use App\Models\Traits\HasHero;
use App\Models\Traits\HasLinks;
use App\Models\Traits\HasMetaData;
use App\Models\Traits\HasTranslations;
use App\Scopes\OrderByStartAtScope;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Nova\Actions\Actionable;
use Spatie\MediaLibrary\InteractsWithMedia;

class Event extends Model implements IHasMetaData
{
    use Actionable,
        HasAssessments,
        HasAuthor,
        HasFactory,
        HasHero,
        HasLinks,
        HasMetaData,
        HasTimestamps,
        HasTranslations,
        InteractsWithMedia,
        SoftDeletes;

    public array $translatable = [
        'name',
        'content',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'starts_at' => 'datetime:M d y',
        'ends_at' => 'datetime:M d y',
        'expires_at' => 'datetime:M d y',
    ];

    public function scopeUpcoming()
    {
        return $this->whereDate('starts_at', '>=', Carbon::now('UTC'))->limit(4);
    }

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        parent::booted();
        static::addGlobalScope(new OrderByStartAtScope);
    }
}
