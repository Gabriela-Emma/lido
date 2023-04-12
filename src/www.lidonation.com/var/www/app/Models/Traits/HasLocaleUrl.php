<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

trait HasLocaleUrl
{
    public function getUrlAttribute()
    {
        return $this->link;
    }

    public function link(): Attribute
    {
        return Attribute::make(
            get: fn () => LaravelLocalization::localizeURL("/{$this->getUrlGroup()}/{$this->slug}/", app()->getLocale()),
        );
    }

    protected function getUrlGroup(): string
    {
        return $this->urlGroup;
    }
}
