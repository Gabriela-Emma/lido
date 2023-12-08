<?php

namespace App\Models\CatalystExplorer;

use App\Models\Traits\HasGravatar;
use App\Models\Traits\HasHero;
use App\Models\Traits\HasLocaleUrl;
use App\Models\Traits\HasMetaData;
use App\Models\User;
use App\Traits\SearchableLocale;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use JetBrains\PhpStorm\Pure;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Spatie\Comments\Models\Concerns\InteractsWithComments;
use Spatie\Comments\Models\Concerns\Interfaces\CanComment;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Staudenmeir\EloquentHasManyDeep\HasRelationships;

/**
 * to index run php artisan ln:index 'App\Models\CatalystLidoUser' ln__catalyst_users
 */
class DRep extends User implements CanComment, HasMedia
{
    use HasGravatar,
        HasHero,
        HasLocaleUrl,
        HasMetaData,
        HasRelationships,
        InteractsWithComments,
        InteractsWithMedia,
        SearchableLocale;

    protected $fillable = ['bio', 'twitter', 'discord', 'linkedin', 'ideascale', 'email'];

    public $table = 'catalyst_dreps';

    protected $hidden = ['email'];

    protected string $urlGroup = 'catalyst-explorer/dreps';

    protected $casts = [
        'name' => 'string',
    ];

    public array $translatable = [
        'bio',
    ];

    public function platformStatement(): Attribute
    {
        return Attribute::make(get: fn () => $this->bio);
    }

    public function link(): Attribute
    {
        return Attribute::make(get: fn () => LaravelLocalization::localizeURL("/project-catalyst/users/{$this->id}/"));
    }

    public function catalyst_voter(): BelongsTo
    {
        return $this->belongsTo(CatalystVoter::class);
    }

    #[Pure]
    public function getGravatarEmailField(): string
    {
        if (!empty($this->email)) {
            return 'email';
        }

        return 'name';
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumbnail')
            ->width(768)
            ->height(512)
            ->withResponsiveImages()
            ->performOnCollections('hero');
    }
}
