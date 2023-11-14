<?php

namespace App\Inertia\Delegators;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Inertia\Response;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        return Inertia::render('Home', [
            'crumbs' => [],
        ]);
    }
}
