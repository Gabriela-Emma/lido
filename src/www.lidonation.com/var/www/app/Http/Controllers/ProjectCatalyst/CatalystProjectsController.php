<?php

namespace App\Http\Controllers\ProjectCatalyst;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Inertia\Response;

class CatalystProjectsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return Inertia::render('Proposals', [
            'crumbs' => [
                [
                    'label' => 'Proposal'
                ],
            ],
        ]);
    }
}
