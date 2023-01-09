<?php

namespace App\Observers;

use App\Models\ModelCategory;
use App\Models\Post;

class ModelCategoryObserver
{
    /**
     * Handle the User "created" event.
     *
     * @param  ModelCategory  $modelCategory
     * @return void
     */
    public function creating(ModelCategory $modelCategory)
    {
        $modelCategory->model_type = Post::class;
    }
}
