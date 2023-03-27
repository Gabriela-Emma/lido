<?php

namespace App\Http\Controllers\Earn;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Inertia\Response;

class LearnController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return Inertia::render('Home');
    }
}
