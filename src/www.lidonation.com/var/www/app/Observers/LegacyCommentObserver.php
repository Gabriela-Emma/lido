<?php

namespace App\Observers;

use App\Invokables\FillPostData;
use App\Models\CatalystExplorer\Assessment;
use Illuminate\Support\Carbon;

class LegacyCommentObserver
{
    /**
     * Handle the LidoUser "created" event.
     */
    public function creating(Assessment $comment): void
    {
        (new FillPostData)($comment, [], fn () => [
            'status' => ['status', 'draft'],
            'published_at' => [null, fn ($model, $key) => ($model->status === 'published' ? Carbon::now('UTC') : null)],
            'user_id' => [null, auth()?->user()?->getAuthIdentifier() ?? 0],
        ]
        );
    }

    public function deleting(Assessment $comment): void
    {
        if ($comment->forceDeleting) {
            $comment->metas()->delete();
        }
    }
}
