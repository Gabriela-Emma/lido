<?php

namespace App\Inertia\CatalystExplorer;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Inertia\Response;

class FundsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return Inertia::render('Funds', [
            'crumbs' => [
                [
                    'label' => 'Funds',
                    'link' => route('catalyst-explorer.funds.index'),
                ],
                ['label' => 'Proposals', 'link' => route('catalyst-explorer.proposals')],
                ['label' => 'Funds', 'link' => '/catalyst-explorer/funds'],
            ],
        ]);
    }
}
