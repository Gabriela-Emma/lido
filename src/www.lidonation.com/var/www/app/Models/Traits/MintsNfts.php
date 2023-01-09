<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Casts\Attribute;

trait MintsNfts
{
    public function totalNfts(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $this->nfts?->sum('qty') ?? 0
        );
    }

    public function mintedNfts(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $this->nfts->sum(function ($nft) {
                return $nft->txs->filter(fn($tx) => in_array($tx->status, ['paid', 'minted', 'minting', 'pending']))?->count() ?? 0;
            }) ?? $value,
        );
    }

    public function availableNftsCount(): Attribute
    {
        return Attribute::make(
            get: fn($value) => ($this->total_nfts - $this->minted_nfts) ?? 0
        );
    }

    public function availableNfts(): Attribute
    {
        return Attribute::make(
            get: function(){
                $nfts = collect();
                $this->nfts->filter(fn($nft) => ($nft->txs_count !== $nft->qty))->each(function($nft) use ($nfts) {
                    for ($x = 0; $x < $nft->qty; $x++) {
                        $nfts->push($nft);
                    }
                });
                return ($nfts->shuffle());
            }
        );
    }
}
