<?php

namespace App\Models\Traits;

use Illuminate\Support\Str;

trait HasSlug
{
    /**
     * Generate unique slug
     *
     * @return array|string ()
     */
    public function createSlug($title): array|string
    {
        if (static::whereSlug($slug = Str::slug($title))->exists()) {
            $max = intval(static::whereTitle($title)->latest('id')->count());

            return "{$slug}-".preg_replace_callback('/(\d+)$/', fn ($matches) => $matches[1] + 1,
                $max);
        }

        return $slug;
    }

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
