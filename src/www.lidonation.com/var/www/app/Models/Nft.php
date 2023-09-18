<?php

namespace App\Models;

use App\Models\Interfaces\HasLink;
use App\Models\Interfaces\IHasMetaData;
use App\Models\Traits\HasAuthor;
use App\Models\Traits\HasHero;
use App\Models\Traits\HasLinks;
use App\Models\Traits\HasModel;
use App\Models\Traits\HasPromos;
use App\Models\Traits\HasTranslations;
use App\Models\Traits\HasTxs;
use App\Nova\LearningTopics;
use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Fluent;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Nft extends Model implements HasLink, HasMedia
{
    use HasAuthor,
        HasHero,
        HasLinks,
        HasModel,
        HasPromos,
        HasTranslations,
        HasTxs,
        InteractsWithMedia,
        SoftDeletes;

    //@todo owner should be an accessor that returns an array from tx-es minted addresses
    protected $hidden = ['artist_id', 'user_id', 'deleted_at', 'model_type', 'model_id', 'media', 'owner', 'txs'];

    // allow masss filling for nft cloning
    protected $guarded = [];

    protected $casts = [
        'metadata' => AsArrayObject::class,
        'updated_at' => 'datetime:Y-m-d',
        'created_at' => 'datetime:Y-m-d',
        'funded_at' => 'datetime:Y-m-d',
        'funding_updated_at' => 'date:Y-m-d',
        'content' => 'array',
    ];

    public $translatable = [
        'name',
        'description',
    ];

    protected $with = ['txs'];

    protected $withCount = ['txs'];

    public function metas(): HasMany
    {
        return $this->hasMany(Meta::class, 'model_id')->where('model_type', static::class);
    }

    /**
     * Get the nft's preview link.
     */
    protected function previewLink(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->thumnail_url ?? $value,
        );
    }

    public function getMetaAttribute(): ?Fluent
    {
        if (!isset($this->metas)) {
            return null;
        }

        return new Fluent(
            $this->metas->map(
                fn ($m) => [$m->key => $m->content]
            )->collapse()
        );
    }

    /**
     * @param  mixed  $model
     * @param  bool  $updateIfExist
     */
    public function saveMeta(string $key, string $content, IHasMetaData $model = null, $updateIfExist = true): bool
    {
        $model = $model ?? $this;
        $meta = null;
        if ($updateIfExist) {
            $meta = Meta::where([
                'key' => $key,
                'model_id' => $model->id,
                'model_type' => $model::class,
            ])->first();
        }

        if (!$meta instanceof Meta) {
            $meta = new Meta;
            $meta->key = $key;
            $meta->model_type = static::class;
            $meta->model_id = $model->id;
        } else {
            if (empty($content)) {
                return $meta->delete();
            }
        }

        $meta->content = $content;

        return $meta->save();
    }

    public function link(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => ''
        );
    }


    public function topic(): Attribute
    {
        return Attribute::make(
            get: function (){
                if($this->model instanceof LearningTopic){
                    return $this->model();
                }else{
                    return null;
                }
            }
        );
    }



    public function artist(): BelongsTo
    {
        return $this->belongsTo(User::class, 'artist_id');
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumbnail')
            ->width(80)
            ->height(80);
        $this->addMediaConversion('preview')
            ->width(640)
            ->height(640);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('hero')->singleFile();
    }
}
