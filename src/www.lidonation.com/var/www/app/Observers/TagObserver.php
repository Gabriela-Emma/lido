<?php

namespace App\Observers;

use App\Models\Tag;
use Illuminate\Support\Str;

class TagObserver
{
    /**
     * Handle the LidoUser "created" event.
     *
     * @return void
     */
    public function creating(Tag $tag)
    {
        if (! $tag->meta_title) {
            $tag->meta_title = $tag->title;
        }
        if (! $tag->slug) {
            $tag->slug = Str::slug($tag->title);
        }
    }
}
