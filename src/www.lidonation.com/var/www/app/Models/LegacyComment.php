<?php

namespace App\Models;

use App\Models\Fund;
use App\Models\Interfaces\IHasMetaData;
use App\Models\Traits\HasAuthor;
use App\Models\Traits\HasGravatar;
use App\Models\Traits\HasMetaData;
use App\Scopes\OrderByDateScope;
use App\Scopes\PublishedScope;
use App\Traits\HasRemovableGlobalScopes;
use App\Traits\SearchableLocale;
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Staudenmeir\EloquentHasManyDeep\HasRelationships;

class LegacyComment extends Model implements IHasMetaData
{
    use HasFactory,
        SoftDeletes,
        HasAuthor,
        HasRemovableGlobalScopes,
        HasMetaData,
        HasGravatar,
        HasTimestamps,
        SearchableLocale,
        HasRelationships;

    protected $with = ['metas', 'parent'];

    protected $guarded = ['user_id', 'created_at'];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime:Y-m-d',
    ];

    protected $appends = [
        'name',
        'email',
        'gravatar',
        //        'children' // cannot eager load children and parent, causes an infinite loop
    ];

    public function getShortJsonAttribute()
    {
        $fields = ['id'];

        return collect($this->toArray())->only($fields)->toJson();
    }

    public function getCreatedAtFormattedAttribute()
    {
        if ($this->parent) {
            return $this->parent->fund?->assessment_started_at->format('F d, Y') ?? null;
        }

        return $this->fund?->assessment_started_at->format('F d, Y') ?? null;
    }

    public function getSummaryAttribute()
    {
        return Str::words($this->content, 12);
    }

    public function getTotalQasAttribute()
    {
        return ($this->assessment_review_assessor?->assessment_review?->excellent_count ?? 0) +
        ($this->assessment_review_assessor?->assessment_review?->good_count ?? 0) +
        ($this->assessment_review_assessor?->assessment_review?->filtered_out_count ?? 0) ?? null;
    }

    public function getEmailAttribute()
    {
        return $this->author?->email ??
            $this->metas?->firstWhere('key', 'email')?->content ?? null;
    }

    public function getNameAttribute()
    {
        return $this->author?->name ??
            $this->metas?->firstWhere('key', 'name')?->content ?? null;
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    /**
     * @return mixed
     *
     * @todo optimize query; reduce to 1 query.
     */
    public function getChildrenAttribute()
    {
        $children = $this->metas?->where('key', 'child_id')->pluck('content');
        if ($children->isEmpty()) {
            return null;
        }
//        $comments = Meta::where([
//            'key' => 'child_id',
//            'content' => $this->id
//        ])->get('model_id')->pluck('model_id')->all();
        return self::find($children);
//        return $this->hasManyThrough(Comment::class, Meta::class, 'child_id', 'model_id', 'model_id');
    }

    public function model(): MorphTo
    {
        return $this->morphTo('model', 'model_type', 'model_id');
    }

    public function rating(): HasOne
    {
        return $this->hasOne(Rating::class, 'comment_id');
    }

    public function fund(): belongsTo
    {
        return $this->belongsTo(Fund::class, 'model_id', 'id');
    }

    public function assessment_review_assessor()
    {
        return $this->hasOne(AssessmentReviewsCommentsAssessors::class, 'assessment_id');
    }

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        parent::booted();
        static::addGlobalScope(new PublishedScope);
        static::addGlobalScope(new OrderByDateScope);
    }
}
