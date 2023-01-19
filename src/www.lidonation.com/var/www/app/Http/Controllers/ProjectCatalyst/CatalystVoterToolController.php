<?php

namespace App\Http\Controllers\ProjectCatalyst;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Inertia\Response;

class CatalystVoterToolController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return Inertia::render('VoterTool', [
            'crumbs' => [
                ['label' => 'Voter Tool'],
            ],
        ]);
    }
}
