<?php

namespace App\Observers;

use App\Invokables\FillPostData;
use App\Models\Post;
use Carbon\Carbon;

class PostObserver
{
    public function saved(Post $post)
    {
        //        dispatch(fn() => Artisan::call('ln:sitemap-generate'));
    }

    /**
     * Handle the LidoUser "created" event.
     */
    public function creating(Post $post): void
    {
        (new FillPostData)($post, [
            'published_at' => [null, fn ($model, $key) => ($model->status === 'published' ? Carbon::now('UTC') : null)],
            'type' => ['type', get_class($post)],
        ]);
    }

    public function deleting(Post $post): void
    {
        if ($post->forceDeleting) {
            $post->metas()->delete();
        }
    }

    protected function generateTranslations(Post $post)
    {
        //        LanguageLine::updateOrCreate(
        //            [
        //                'group' => 'posts',
        //                'key' => $post->slug,
        //            ],
        //            [
        //                'group' => 'posts',
        //                'key' => $post->slug,
        //                'text' => [
        //                    'en' => $post->content,
        //                ],
        //            ]
        //        );
    }
}
