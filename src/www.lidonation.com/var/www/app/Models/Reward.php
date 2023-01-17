<?php

namespace App\Models;

use App\Models\Traits\HasAuthor;
use App\Models\Traits\HasMetaData;
use App\Models\Traits\HasModel;
use App\Models\Traits\HasTranslations;
use App\Models\Traits\HasTxs;
use App\Services\CardanoBlockfrostService;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Fluent;

class Reward extends Model
{
    use HasAuthor,
        HasMetaData,
        HasModel,
        HasTimestamps,
        HasTranslations,
        HasTxs,
        SoftDeletes;

    public $translatable = [
        'memo',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'amount' => 'integer',
    ];

    public $appends = ['asset_details'];

    public function assetDetails(): Attribute
    {
        return Attribute::make(get: function ($value) {
            $asset = $this->asset;
            if ($asset === 'lovelace') {
                return new Fluent([
                    'asset_name' => 'Ada',
                    'divisibility' => intval(str_pad(1, 7, '0')),
                    'metadata' => new Fluent([
                        'ticker' => 'Ada',
                        'logo' => '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GkiKwURFb7kY3A50TT2Q9nE//LnbDoMq5VKdxx7bS7PdptmZxYVtrKkyNwtp4ui0LWlUw8dD+KSKNSFJdpwomUGCCo8/8SKttqHdTMGHebWqDuvdQDatCxg1iLpx48OG8SHGO4z1FHVHjBBfJ/jpAb1dbvKgBmvLTE7+mttu+w6t1gxKRJpF+ExxpkzUTrnzju9z++3foxNlZBkYYwkCQ22oTJp2+PZtt/Lsb54mTuJ86QEV604yTuTdmEbS6/PKNkXwyM7JX9AddHlfRf3ItZ7wK76YBnRr+AFB+khEUJ2fLNA/sQaMc9x0003U6jU+8hcfIQhK5OPGOD9ptfmGNR9vuZ6TLlpUaoqpXtrXhMyzF6vpZ96x/uyvGqLec2Xy0Z2908gkxGcjKOUJL34sn80M2tBiWujqBxFtxx2ccxhjqFVrdDqd/KqiUahFFuBVEQXpO8BuiSJKXzzsaocbd0Qf37B+FIiX3E3RO4ivRtLGQAxakpavUOr1OuVyXpj5ZQZdcoK8TfAIMYY0t48u4xtGWtdjWov2ZxZ9zF9RmUbiTblQ/3dSVeI4RlUJXEAURcsKtZAGW7/dlrRvGNJNxrQalmgQOXpD4z5oTUyuj64BbIJgohgDLnG0CzbYZ2MiggV8kvaeIgA6P7XV+YsXfFHMbyFvTysY0gaSbhIfN/KEIB6oaAYR0j6j7rpy0gb4TeQvG/1BqZvmiDqMGqymDSHeZIkaRiIMMe4EaC9WOTP/NlQBZ4EU9/whBfLFoMBmITZz9xjSi420GkbmMNKaH7EsCE6LnEK3Yd8dzltiLHHDEl9tNf2MVT9tFay+2ldeVqC+vnn/Hox6BD9tiD9jia62RNOWuNdNFQXxJ/Bp8znBgjFKgdrO3VPz79/gwIej4K5D3eZMIDPz6cmrITOwiYVZSe5VRT2IHzek11+2/vyGGchU5p91oqcuRgjTa+6hYDXFEpHrbYSRqGGItxiJzrLEt/yevecFtMDlSzotpOOYeBMSf1yIGxBBL3Au6aJ75FZuzfXNhyQGTYEWYBrgtkD1OgjHgC3AO38veaSXATwM/h4kHUf9tOlmBbJYiJXo1U9fugt3/b540DJQbgDjBY+Qd5DGmH89c6TgLjUKngKmkHQK/DRF89/0ZrgelnmFZin6X0R9p39m4chAAAAAJXRFWHRkYXRlOmNyZWF0ZQAyMDIyLTEyLTA4VDA1OjQwOjM4KzAwOjAwUJqEnwAAACV0RVh0ZGF0ZTptb2RpZnkAMjAyMi0xMi0wOFQwNTo0MDozOCswMDowMCHHPCMAAAAodEVYdGRhdGU6dGltZXN0YW1wADIwMjItMTItMDhUMDU6NDA6MzgrMDA6MDB20h38AAAAOHRFWHRpY2M6Y29weXJpZ2h0AENvcHlyaWdodCAoYykgMTk5OCBIZXdsZXR0LVBhY2thcmQgQ29tcGFueflXeTcAAAAhdEVYdGljYzpkZXNjcmlwdGlvbgBzUkdCIElFQzYxOTY2LTIuMVet2kcAAAAmdEVYdGljYzptYW51ZmFjdHVyZXIASUVDIGh0dHA6Ly93d3cuaWVjLmNoHH8ATAAAADd0RVh0aWNjOm1vZGVsAElFQyA2MTk2Ni0yLjEgRGVmYXVsdCBSR0IgY29sb3VyIHNwYWNlIC0gc1JHQkRTSKkAAAAASUVORK5CYII=',
                    ]),
                ]);
            }
            $asset = app(CardanoBlockfrostService::class)
                ->get("assets/{$asset}/", null)
                ->object();

            if (isset($asset?->metadata) && ($asset?->metadata?->decimals ?? null) > 0) {
                $asset->divisibility = intval(str_pad(1, $asset->metadata?->decimals + 1, '0'));
            } else {
                $asset->divisibility = 1;
            }

            return $asset;
        });
    }

    public function withdrawal(): BelongsTo
    {
        return $this->belongsTo(Withdrawal::class);
    }
}
