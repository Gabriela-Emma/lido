<?php

namespace App\Models;

use App\DataTransferObjects\LearningLessonData;
use App\Models\CatalystExplorer\CatalystUser;
use App\Models\Traits\HasCatalystProfiles;
use App\Models\Traits\HasGravatar;
use App\Models\Traits\HasMetaData;
use App\Models\Traits\HasPromos;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Jetstream\HasTeams;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Comments\Models\Concerns\InteractsWithComments;
use Spatie\Comments\Models\Concerns\Interfaces\CanComment;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Permission\Traits\HasRoles;
use Staudenmeir\EloquentHasManyDeep\HasRelationships;
use Staudenmeir\EloquentJsonRelations\HasJsonRelationships;

class User extends Authenticatable implements CanComment, CanResetPassword, HasMedia, Interfaces\IHasMetaData, MustVerifyEmail
{
    use HasApiTokens,
        HasCatalystProfiles,
        HasFactory,
        HasGravatar,
        HasJsonRelationships,
        HasMetaData,
        HasProfilePhoto,
        HasPromos,
        HasRelationships,
        HasRoles,
        HasTeams,
        InteractsWithComments,
        InteractsWithMedia,
        Notifiable,
        Notifiable,
        TwoFactorAuthenticatable;

    protected $with = ['media'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'lang',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'email',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'what_filter' => 'json',
        'nextLesson' => LearningLessonData::class,
        //        'what_filter' => NRTFilter::class
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
        //        'next_lesson',
        //        'next_lesson_at',
        //        'total_reward_sum',
        //        'available_rewards',

    ];

    public function getFacebookLinkAttribute(): ?string
    {
        $user = $this->metas?->firstWhere('key', 'facebook_user')?->content;
        if (isset($user)) {
            return "//www.facebook.com/$user";
        }

        return null;
    }

    /**
     * @throws GuzzleException
     */
    public function getHasLidoNftAttribute(): ?bool
    {
        return false;
        //        return app(CardanoGraphQLService::class)
        //        ->getAddressesTokenUtxos(config('cardano.mint.policies.lido_delegate'))->isNotEmpty();
    }

    public function getTwitterLinkAttribute(): ?string
    {
        $user = $this->metas?->firstWhere('key', 'twitter_handler')?->content;
        if (isset($user)) {
            return "//www.twitter.com/$user";
        }

        return null;
    }

    public function getSocialLinksAttribute(): Collection
    {
        return collect([
            'twitter' => $this->twitter_link,
            'facebook' => $this->facebook_link,
        ])->filter();
    }

    public function getBioPicAttribute(): ?Media
    {
        $media = $this->media->filter(fn ($m) => $m->collection_name === 'profile');
        if ($media->isNotEmpty()) {
            return $media->first();
        }

        return null;
    }

    public function getPendingPhuffycoinMintsAttribute()
    {
        return $this->mint_txs_phuffycoin()?->where('status', 'pending')->sum('amount');
    }

    /**
     * @throws GuzzleException
     */
    public function getPhuffyCoinBalanceAttribute(): int
    {
        return 0;
        //        [$txs, $aggregate] = app(CardanoGraphQLService::class)
        //            ->getStakeAddressTokenTxs($this, null, true);
        //
        //        return humanNumber($aggregate?->sum?->quantity, 2);
    }

    public function getShortBioAttribute()
    {
        if (isset($this->attributes['short_bio'])) {
            return $this->attributes['short_bio'];
        }

        return Str::words($this->bio, 20);
    }

    public function getCatalystRolesAttribute()
    {
        return $this->roles->filter(fn ($role) => Str::contains($role, 'catalyst'));
    }

    /**
     * Get the URL to the user's profile photo.
     */
    public function getBioPicUrlAttribute(): string
    {
        return $this->hero?->getfullUrl('large') ?? $this->profile_photo_url;
    }

    public function getGravatarAttribute(): string
    {
        if ($this->bio_pic) {
            return $this->bio_pic->getUrl('thumbnail');
        }
        $hash = md5(strtolower(trim($this->{$this->email})));

        return "https://www.gravatar.com/avatar/$hash?d=identicon&r=r";
    }

    public function nextLesson(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->last_learning_attempt?->learning?->next_lesson
        );
    }

    public function nextLessonAt(): Attribute
    {
        return Attribute::make(
            get: function () {
                return Carbon::make(
                    $this->last_learning_attempt
                        ?->created_at
                        ->setTimezone('Africa/Nairobi')
                        ->addDay()
                        ->toAtomString()
                )?->utc()?->toAtomString();
            }
        );
    }

    public function totalRewardSum(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->rewards()
                ->where('model_type', LearningLesson::class)
                ->sum('amount')
        );
    }

    public function availableRewards(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->rewards()
                ->where('status', 'issued')
                ->orderBy('created_at', 'desc')->get()
        );
    }

    public function completedTopics(): Attribute
    {
        return Attribute::make(
            get: function () {
                $topics = LearningTopic::whereRelation('learningLessons.answers', 'user_id', $this->id)->get();

                return $topics->filter(function ($topic) {
                    $completedLessonsCount = $topic->learningLessons()->whereHas(
                        'answers',
                        fn ($query) => $query->where('user_id', $this->id)
                            ->whereRelation('answer', 'correctness', 'correct')
                    )->count();

                    return $topic->learningLessons()->count() == $completedLessonsCount;
                });
            }
        );
    }

    public function scopeIncludeDuplicates(Builder $query, $include = true): Builder
    {
        if ($include) {
            return $query;
        }

        return $query->whereDoesntHave('primary_account');
    }

    public function follows(CatalystUser|int $catalystUser): bool
    {
        return $this->whereHas('following', fn ($q) => $q->whereIn('what_id', [$catalystUser?->id ?? $catalystUser]))->count() > 0;
    }

    /**
     * The roles that belong to the user.
     */
    public function following(): HasManyThrough
    {
        return $this->hasManyThrough(CatalystUser::class, NotificationRequestTemplate::class, 'who_id', 'id', 'id', 'what_id');
    }

    public function catalyst_users(): HasMany
    {
        return $this->hasMany(CatalystUser::class, 'claimed_by');
    }

    public function mint_txs(): HasMany
    {
        return $this->hasMany(MintTx::class, 'user_id');
    }

    public function promos(): HasMany
    {
        return $this->hasMany(Promo::class, 'user_id');
    }

    public function nfts(): HasMany
    {
        return $this->hasMany(Nft::class);
    }

    public function mint_txs_phuffycoin(): HasMany
    {
        return $this->hasMany(MintTx::class, 'user_id')
            ->where('policy_id', config('cardano.mint.policies.phuffycoin'));
    }

    public function rewards(): HasMany
    {
        return $this->hasMany(Reward::class, 'user_id');
    }

    public function answers(): HasMany
    {
        return $this->hasMany(AnswerResponse::class, 'user_id');
    }

    public function pendingWithdrawals(): HasMany
    {
        return $this->hasMany(Withdrawal::class, 'user_id')->whereNotIn('status', ['sent', 'canceled']);
    }

    public function withdrawals(): HasMany
    {
        return $this->hasMany(Withdrawal::class, 'user_id');
    }

    public function quiz_responses(): HasMany
    {
        return $this->hasMany(AnswerResponse::class, 'user_id');
    }

    public function last_learning_attempt(): HasOne
    {
        return $this->hasOne(LearningAttempt::class)->latestOfMany();
    }

    public function learning_attempts(): HasMany
    {
        return $this->hasMany(LearningAttempt::class)->orderByDesc('created_at');
    }

    public function signatures(): HasMany
    {
        return $this->hasMany(Signature::class);
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumbnail')
            ->width(150)
            ->height(150)
            ->withResponsiveImages()
            ->crop(Manipulations::CROP_TOP, 150, 150)
            ->performOnCollections('profile');
        $this->addMediaConversion('large')
            ->width(1080)
            ->height(1350)
            ->crop(Manipulations::CROP_TOP, 1080, 1350)
            ->withResponsiveImages()
            ->performOnCollections('profile');
    }

    public function primary_account(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function duplicate_accounts(): HasMany
    {
        return $this->hasMany(User::class, 'primary_account_id');
    }

    public function __toString()
    {
        return $this->name;
    }
}
