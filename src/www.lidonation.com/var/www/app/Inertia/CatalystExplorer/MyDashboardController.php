<?php

namespace App\Inertia\CatalystExplorer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class MyDashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        return Inertia::render('Auth/Dashboard', [
            'crumbs' => [
                ['label' => 'Dashboard'],
            ],
        ]);
    }
}
