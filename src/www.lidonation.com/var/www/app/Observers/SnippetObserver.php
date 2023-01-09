<?php

namespace App\Observers;

use App\Invokables\FillPostData;
use App\Models\Snippet;

class SnippetObserver
{
    /**
     * Handle the User "created" event.
     *
     * @param  Snippet  $snippet
     * @return void
     */
    public function creating(Snippet $snippet)
    {
        (new FillPostData)($snippet, [], fn () => [
            'type' => ['type', $snippet::class],
            'order' => ['order', 0],
            'context' => ['context', 'global'],
            'status' => ['status', 'draft'],
            'user_id' => [null, auth()?->user()?->getAuthIdentifier() ?? 1],
        ]);
        // $snippet->generateLanguageLines();
    }

    /**
     * Handle the User "created" event.
     *
     * @param  Snippet  $snippet
     * @return void
     */
    public function updating(Snippet $snippet)
    {
        // $snippet->saveLanguageLines($snippet);
    }

    public function deleting(Snippet $post)
    {
        if ($post->forceDeleting) {
            $post->metas()->delete();
        }
    }
}
