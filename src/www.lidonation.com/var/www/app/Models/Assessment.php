<?php

namespace App\Models;

use App\Models\Interfaces\IHasMetaData;
use App\Models\Traits\HasAuthor;
use App\Models\Traits\HasFlags;
use App\Models\Traits\HasGravatar;
use App\Models\Traits\HasMetaData;
use App\Scopes\OrderByDateScope;
use App\Scopes\PublishedScope;
use App\Traits\HasRemovableGlobalScopes;
use App\Traits\SearchableLocale;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;
use Spatie\Comments\Models\Concerns\HasComments;
use Staudenmeir\EloquentHasManyDeep\HasRelationships;

class Assessment extends Model implements IHasMetaData
{
    use HasAuthor,
        HasComments,
        HasFlags,
        HasFactory,
        HasGravatar,
        HasRelationships,
        HasRemovableGlobalScopes,
        HasMetaData,
        HasTimestamps,
        SearchableLocale,
        SoftDeletes;

    protected $table = 'legacy_comments';

    protected $with = ['metas', 'parent', 'comments'];

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
        //        'children' // cannot eager load children and parent, causes an infinite loop
    ];

    /*
    * This string will be used in notifications on what a new comment
    * was made.
    */
    public function commentableName(): string
    {
        return $this->model?->proposal?->title ?? '';
    }

    /*
     * This URL will be used in notifications to let the user know
     * where the comment itself can be read.
     */
    public function commentUrl(): string
    {
        return $this->model?->proposal?->link ?? '';
    }

    public function getShortJsonAttribute()
    {
        $fields = ['id'];

        return collect($this->toArray())->only($fields)->toJson();
    }

    public static function getSearchableAttributes(): array
    {
        return [
            'rationale',
            'assessor',
            'qa_rationale',
            'proposal.title',
            'proposal.users.name',
            'proposal.users.username',
        ];
    }

    public static function getRankingRules(): array
    {
        return [
            'words',
            'sort',
            'attribute',
            'exactness',
        ];
    }

    public static function getFilterableAttributes(): array
    {
        return [
            'rating',
            'proposal.id',
            'proposer.fund',
            'proposer.challenge',
            'proposer.funded',
            'proposer.groups.id',
            'assessor',
            'qa_good_count',
            'qa_rating_outcome',
            'qa_excellent_count',
            'qa_filtered_out_count',
            'flagged',
        ];
    }

    public static function getSortableAttributes(): array
    {
        return [
            'rating',
            'qa_excellent_count',
            'qa_good_count',
            'qa_filtered_out_count',
        ];
    }

    public static function runCustomIndex()
    {
        Artisan::call('ln:index App\\\\Models\\\\Assessment ln__catalyst_assessments');
    }

    public function getCreatedAtFormattedAttribute()
    {
        if ($this->parent) {
            return $this->parent->fund?->assessment_started_at?->format('F d, Y') ?? null;
        }

        return $this->fund?->assessment_started_at?->format('F d, Y') ?? null;
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

    public function name(): Attribute
    {
        return Attribute::make(get: fn () => $this->author?->name ??
            $this->metas?->firstWhere('key', 'name')?->content ?? null);
    }

    /**
     * @return mixed
     */
    public function children(): Attribute
    {
        $children = $this->metas?->where('key', 'child_id')->pluck('content');

        return Attribute::make(get: fn () => $children->isEmpty() ? null : self::fund($children));
    }

    public function discussion(): BelongsTo
    {
        return $this->belongsTo(Discussion::class, 'model_id');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
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
     * Get the indexable data array for the model.
     */
    public function toSearchableArray(): array
    {
        //        $array = $this->toArray();
        $proposal = collect($this->model?->model?->toSearchableArray())
            ->only(['id', 'slug', 'title', 'users', 'fund', 'challenge', 'groups', 'funded', 'completed']);

        return [
            'id' => $this->id,
            'label' => $this->model?->title,
            'rationale' => $this->content,
            'proposal' => $proposal,
            'assessor' => $this->assessment_review_assessor?->assessor?->assessor_id,
            'rating' => $this->rating?->rating,
            'qa_excellent_count' => $this->assessment_review_assessor?->assessment_review?->excellent_count,
            'qa_good_count' => $this->assessment_review_assessor?->assessment_review?->good_count,
            'qa_filtered_out_count' => $this->assessment_review_assessor?->assessment_review?->filtered_out_count,
            'qa_rationale' => $this->assessment_review_assessor?->assessment_review?->qa_rationale,
            'flagged' => $this->assessment_review_assessor?->assessment_review?->flagged,
        ];
    }

    public function searchableAs()
    {
        return 'ln__catalyst_assessments';
    }

    /**
     * Determine if the model should be searchable.
     */
    public function shouldBeSearchable(): bool
    {
        return $this->model?->model_type == Proposal::class;
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
