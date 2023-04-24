<?php

namespace App\Observers;

use App\Invokables\FillPostData;
use App\Models\LearningModule;
use Illuminate\Support\Str;

class LearningModuleObserver
{
    /**
     * Handle the User "created" event.
     */
    public function creating(LearningModule $learningModule): void
    {
        (new FillPostData)($learningModule, [], fn () => [
            'slug' => [null, fn ($model, $key) => $model->slug ?? Str::slug($model->title)],
        ]);
    }

    /**
     * Handle the User "created" event.
     */
    public function forceDeleting(LearningModule $learningModule): void
    {
        if ($learningModule->forceDeleting) {
            $learningModule->metas()->delete();
        }
    }
}
