<?php

namespace App\Models;

use App\Models\Traits\HasCatalystProfiles;
use App\Models\Traits\HasGravatar;
use App\Models\Traits\HasMetaData;
use App\Models\Traits\HasPromos;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
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

class User extends Authenticatable implements HasMedia, Interfaces\IHasMetaData, CanComment, CanResetPassword
{
    use HasApiTokens,
        HasCatalystProfiles,
        InteractsWithMedia,
        InteractsWithComments,
        HasFactory,
        HasProfilePhoto,
        HasTeams,
        HasPromos,
        Notifiable,
        HasGravatar,
        TwoFactorAuthenticatable,
        HasMetaData,
        HasRoles,
        Notifiable;

    protected $with = ['media'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
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
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
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
     *
     * @return string
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

    public function mint_txs_phuffycoin(): HasMany
    {
        return $this->hasMany(MintTx::class, 'user_id')
            ->where('policy_id', config('cardano.mint.policies.phuffycoin'));
    }

    public function rewards(): HasMany
    {
        return $this->hasMany(Reward::class, 'user_id');
    }

    public function pendingWithdrawals(): HasMany
    {
        return $this->hasMany(Withdrawal::class, 'user_id')->whereNotIn('status', ['sent', 'canceled']);
    }

    public function withdrawals(): HasMany
    {
        return $this->hasMany(Withdrawal::class, 'user_id');
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

    public function __toString()
    {
        return $this->name;
    }
}
