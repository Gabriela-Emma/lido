<?php

namespace App\Inertia\Earn;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;
use Momentum\Modal\Modal;

class EarnController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Modal|RedirectResponse
     */
    public function addWallet(): Modal|RedirectResponse
    {
        if (previous_route_name_is('earn.wallet.add')) {
            return to_route('earn.learn.modules.index');
        } else {
            return Inertia::modal('AddWallet')
                ->baseURL(url()->previous());
        }
    }

    public function duplicateAccount(): Modal|RedirectResponse
    {
        if (previous_route_name_is('earn.learn.duplicate')) {
            return to_route('earn.learn');
        } else {
            return Inertia::modal('DuplicateAccount')
                ->baseRoute('earn.learn');
        }
    }

    public function awardNft(): Modal
    {
        $user = User::find(Auth::id());
        $topicId = $user->learning_attempts->first()->learning_topic_id;
        $topicNft = $user->nfts()->where([
            ['model_id', $topicId],
            ['model_type', 'App\Models\LearningTopic'],
        ])->first();

        return Inertia::modal('NftAwarded')
            ->with([
                'nft' => $topicNft,
            ])
            ->baseURL(url()->previous());
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(): Response
    {
        return Inertia::render('Earn')->with([
            'crumbs' => [
                ['name' => 'Ways to Earn', 'link' => route('earn.home')],
            ],
            'learnOpen' => config('app.slte.registration_open'),
        ]);
    }

    public function ccv4(): Response
    {
        return Inertia::render('CCv4')->with([
            'crumbs' => [
                ['name' => 'Ways to Earn', 'link' => route('earn.home')],
                ['name' => 'CCv4', 'link' => route('earn.ccv4')],
            ],
        ]);
    }

    public function storeWallet(): true
    {
        $u = Auth::user();
        $u->wallet_address = request('wallet_address');
        $u->wallet_stake_address = request('wallet_stake_address');
        $u->save();

        return true;
    }
}
