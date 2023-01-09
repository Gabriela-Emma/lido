<?php

namespace App\Observers;

use App\Invokables\FillPostData;
use App\Models\LegacyComment;
use Illuminate\Support\Carbon;

class LegacyCommentObserver
{
    /**
     * Handle the User "created" event.
     *
     * @param  LegacyComment  $comment
     * @return void
     */
    public function creating(LegacyComment $comment): void
    {
        (new FillPostData)($comment, [], fn () => [
            'status' => ['status', 'draft'],
            'published_at' => [null, fn ($model, $key) => ($model->status === 'published' ? Carbon::now('UTC') : null)],
            'user_id' => [null, auth()?->user()?->getAuthIdentifier() ?? 0],
        ]
        );
    }

    public function deleting(LegacyComment $comment): void
    {
        if ($comment->forceDeleting) {
            $comment->metas()->delete();
        }
    }
}
