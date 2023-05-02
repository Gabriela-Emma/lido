<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Auth;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Vinkla\Hashids\Facades\Hashids;

trait HashIdModel
{
    use HasLocaleUrl;

    public function hash(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Hashids::connection(static::class)->encode($this->id)
        );
    }

    public function rawId(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->getRawOriginal('id')
        );
    }

    public function link(): Attribute
    {
        return Attribute::make(
            get: fn () => LaravelLocalization::getLocalizedURL( Auth::user()?->lang ?? app()->getLocale(), "{$this->getUrlGroup()}/{$this->hash}/")
        );
    }
}
