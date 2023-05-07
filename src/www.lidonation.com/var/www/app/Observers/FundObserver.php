<?php

namespace App\Observers;

use App\Invokables\FillPostData;
use App\Models\Fund;
use Illuminate\Support\Facades\Artisan;

class FundObserver
{
    public function saved(Fund $fund)
    {
        dispatch(fn () => Artisan::call('ln:sitemap-generate'));
    }

    /**
     * Handle the User "created" event.
     *
     * @return void
     */
    public function creating(Fund $fund)
    {
        (new FillPostData)($fund);
    }

    public function deleting(Fund $post)
    {
        if ($post->forceDeleting) {
            $post->metas()->delete();
        }
    }

    protected function generateTranslations(Fund $fund)
    {
        //        LanguageLine::updateOrCreate(
        //            [
        //                'group' => 'funds',
        //                'key' => $fund->slug,
        //            ],
        //            [
        //                'group' => 'funds',
        //                'key' => $fund->slug,
        //                'text' => [
        //                    'en' => $fund->content,
        //                ],
        //            ]
        //        );
    }
}
