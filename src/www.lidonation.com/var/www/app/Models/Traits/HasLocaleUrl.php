<?php

namespace App\Models\Traits;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\UrlGenerator;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

trait HasLocaleUrl
{
    public function getUrlAttribute()
    {
        return $this->link;
    }

    public function getLinkAttribute(): string|UrlGenerator|Application
    {
        $urlGroup = $this->getUrlGroup();

        return LaravelLocalization::localizeURL("/{$urlGroup}/{$this->slug}/", app()->getLocale());
    }

    protected function getUrlGroup(): string
    {
        return $this->urlGroup;
    }
}
