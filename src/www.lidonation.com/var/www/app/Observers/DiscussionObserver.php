<?php

namespace App\Observers;

use App\Invokables\FillPostData;
use App\Models\Discussion;
use App\Models\Post;

class DiscussionObserver
{
    /**
     * Handle the Discussion "created" event.
     *
     * @param  Discussion  $discussion
     * @return void
     */
    public function creating(Discussion $discussion)
    {
        (new FillPostData)($discussion, [], fn () => ([
            'model_type' => [
                'type',
                fn ($model, $key) => (
                    (Post::findOrFail($model->model_id))->type
                ),
            ],
            'order' => ['order', 0],
            'status' => ['status', 'draft'],
            // set publish_at to now() if post is being published & published_at is not set
            'published_at' => [null, fn ($model, $key) => ($model->status === 'published' ? now() : null)],
            'user_id' => [null, auth()?->user()?->getAuthIdentifier()],
        ]));
    }

    public function deleting(Discussion $post)
    {
        if ($post->forceDeleting) {
            $post->metas()->delete();
            $post->comments()->delete();
        }
    }
}
