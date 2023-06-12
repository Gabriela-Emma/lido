<?php

namespace App\Http\Controllers\Earn;

use App\Http\Controllers\Controller;
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
    public function addWallet()
    {
        if (previous_route_name_is('earn.wallet.add')) {
            return to_route('earn.learn.modules.index');
        } else {
            return Inertia::modal('AddWallet')
                ->baseURL(url()->previous());
        }
    }

    public function duplicateAccount()
    {
        if (previous_route_name_is('earn.learn.duplicate')) {
            return to_route('earn.learn');
        } else {
            return Inertia::modal('DuplicateAccount')
                ->baseRoute('earn.learn');
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return Inertia::render('Earn')->with([
            'crumbs' => [
                ['name' => 'Ways to Earn', 'link' => route('earn.home')],
            ],
        ]);
    }

    public function ccv4()
    {
        return Inertia::render('CCv4')->with([
            'crumbs' => [
                ['name' => 'Ways to Earn', 'link' => route('earn.home')],
                ['name' => 'CCv4', 'link' => route('earn.ccv4')],
            ],
        ]);
    }

    public function storeWallet()
    {
        $u = Auth::user();
        $u->wallet_address = request('wallet_address');
        $u->wallet_stake_address = request('wallet_stake_address');
        $u->save();

        return true;
    }
}
