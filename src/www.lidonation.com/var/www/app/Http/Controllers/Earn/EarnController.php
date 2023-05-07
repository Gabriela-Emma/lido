<?php

namespace App\Http\Controllers\Earn;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Inertia\Response;

class EarnController extends Controller
{
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
}
