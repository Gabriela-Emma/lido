<?php

namespace App\Observers;

use App\Models\Category;
use Illuminate\Support\Str;

class CategoryObserver
{
    /**
     * Handle the User "created" event.
     *
     * @return void
     */
    public function creating(Category $category)
    {
        if (! $category->meta_title) {
            $category->meta_title = $category->title;
        }
        if (! $category->slug) {
            $category->slug = Str::slug($category->title);
        }
    }
}
