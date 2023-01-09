<?php

namespace App\Observers;

use App\Invokables\FillPostData;
use App\Models\Proposal;

class ProposalObserver
{
    public function saved(Proposal $proposal)
    {
//        dispatch(fn() => Artisan::call('ln:sitemap-generate'));
    }

    /**
     * Handle the User "created" event.
     *
     * @param  Proposal  $proposal
     * @return void
     */
    public function creating(Proposal $proposal)
    {
        (new FillPostData)($proposal, [], fn () => [
            'type' => ['type', 'proposal'],
        ]);
    }

    public function deleting(Proposal $proposal)
    {
        if ($proposal->forceDeleting) {
            $proposal->metas()->delete();
        }
    }

    protected function generateTranslations(Proposal $proposal)
    {
//        LanguageLine::updateOrCreate(
//            [
//                'group' => 'proposals',
//                'key' => $proposal->slug,
//            ],
//            [
//                'group' => 'proposals',
//                'key' => $proposal->slug,
//                'text' => [
//                    'en' => $proposal->content,
//                ],
//            ]
//        );
    }
}
