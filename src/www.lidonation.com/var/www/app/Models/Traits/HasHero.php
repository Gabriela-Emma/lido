<?php

namespace App\Models\Traits;

trait HasHero
{
    public function getHeroUrlAttribute()
    {
        if (isset($this->attributes['heroUrl'])) {
            return $this->attributes['heroUrl'];
        }

        $heroUrl = $this->hero?->getfullUrl();

        if ($this->isValidImageFormat($heroUrl)) {
            return $heroUrl;
        }

        return null;
    }

    private function isValidImageFormat($heroUrl)
    {
        $fileExt = pathinfo($heroUrl, PATHINFO_EXTENSION);

        return in_array($fileExt, ['jpeg', 'png', 'jpg']);
    }

    public function getThumbnailUrlAttribute()
    {
        if (isset($this->attributes['thumbnailUrl'])) {
            return $this->attributes['thumbnailUrl'];
        }
        if (! $this->hero?->hasGeneratedConversion('thumbnail')) {
            return null;
        }

        return $this->hero?->getfullUrl('thumbnail');
    }

    public function getFeatureUrlAttribute()
    {
        if (isset($this->attributes['featureUrl'])) {
            return $this->attributes['featureUrl'];
        }

        if (! $this->hero?->hasGeneratedConversion('preview')) {
            return null;
        }

        return $this->hero?->getfullUrl('preview');
    }

    public function getHeroAttribute()
    {
        $media = $this->media->filter(fn ($m) => $m->collection_name === 'hero')->sortBy('order_column');
        if ($media->isNotEmpty()) {
            return $media->first();
        }

        if ($this->parent) {
            if (isset($this->parent?->media) && $this->parent->media->isNotEmpty()) {
                return $this->parent?->media->first();
            }
        }

        if ($this->categories) {
            if (isset($this->categories->first()?->media) && $this->categories->first()?->media->isNotEmpty()) {
                return $this->categories->first()?->media->first();
            }
        }

        return null;
    }
}
