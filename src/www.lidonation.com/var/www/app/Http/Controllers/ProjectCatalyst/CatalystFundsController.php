<?php

namespace App\Http\Controllers\ProjectCatalyst;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Inertia\Response;

class CatalystFundsController extends Controller
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
                ['link' => '/project-catalyst/funds', 'label' => 'Funds'],
                ['label' => 'Fund 6'],
            ],
        ]);
    }
}
