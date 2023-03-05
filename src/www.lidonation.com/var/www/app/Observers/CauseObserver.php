<?php

namespace App\Observers;

use App\Invokables\FillPostData;
use App\Models\Cause;
use Carbon\Carbon;
use Illuminate\Support\Facades\Artisan;

class CauseObserver
{
    public function saved(Cause $Cause)
    {
        dispatch(fn () => Artisan::call('ln:sitemap-generate'));
    }

    /**
     * Handle the User "created" event.
     *
     * @return void
     */
    public function creating(Cause $Cause)
    {
        (new FillPostData)($Cause, [
            'published_at' => [null, fn ($model, $key) => ($model->status === 'published' ? Carbon::now('UTC') : null)],
        ]);
    }

    public function deleting(Cause $post)
    {
        if ($post->forceDeleting) {
            $post->metas()->delete();
        }
    }
}
