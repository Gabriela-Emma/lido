<?php

namespace App\Models;

use App\Models\Interfaces\HasRewardsContract;
use App\Models\Traits\HasAuthor;
use App\Models\Traits\HasHero;
use App\Models\Traits\HasMetaData;
use App\Models\Traits\HasModel;
use App\Models\Traits\HasRewards;
use App\Models\Traits\HasRules;
use App\Models\Traits\HasTranslations;
use App\Models\Traits\HasWallets;
use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Giveaway extends Model implements HasMedia, Interfaces\HasRules, HasRewardsContract
{
    use HasAuthor,
        HasHero,
        HasMetaData,
        HasModel,
        HasRules,
        HasTimestamps,
        HasTranslations,
        HasWallets,
        HasRewards,
        InteractsWithMedia,
        SoftDeletes;

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'updated_at' => 'datetime:M d y',
        'published_at' => 'datetime:M d y',
        'tx_metadata' => AsArrayObject::class,
    ];

    public $translatable = [
        'title',
        'content',
        'meta_title',
        'social_excerpt',
    ];

    /**
     * Get the user's first name.
     */
    public function balances(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                $wallet = $this->wallets?->first();
                $seed = $wallet?->passphrase;

                return Cache::remember($wallet->address, 900, function () use ($seed) {
                    try {
                        return Http::post(
                            config('cardano.lucidEndpoint').'/wallet/balances',
                            compact('seed')
                        )->throw()->collect()->map(function ($asset) {
                            $asset['amount'] = $asset['amount'] - $this->rewards->filter(fn ($r) => $r->asset === $asset['asset'])->sum('amount');

                            return $asset;
                        });
                    } catch (\Exception $e) {
                        return null;
                    }
                });
            },
        );
    }

    // public function rewards(): HasMany
    // {
    //     return $this->hasMany(Reward::class, 'model_id')
    //         ->where('model_type', static::class);
    // }
}
