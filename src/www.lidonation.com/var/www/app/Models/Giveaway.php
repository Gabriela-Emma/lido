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
use App\Services\LucidService;
use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Giveaway extends Model implements HasMedia, HasRewardsContract, Interfaces\HasRules
{
    use HasAuthor,
        HasFactory,
        HasHero,
        HasMetaData,
        HasModel,
        HasRewards,
        HasRules,
        HasTimestamps,
        HasTranslations,
        HasWallets,
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

                return app(LucidService::class)
                    ->getWalletBalances($seed)
                    ->map(function ($asset) {
                        $asset['amount'] = $asset['amount'] - $this->rewards->filter(fn ($r) => $r->asset === $asset['asset'])->sum('amount');

                        return $asset;
                    });

            },
        );
    }
}
