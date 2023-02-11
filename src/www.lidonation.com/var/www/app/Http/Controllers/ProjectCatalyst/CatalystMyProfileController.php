<?php

namespace App\Http\Controllers\ProjectCatalyst;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class CatalystMyProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        return Inertia::render('auth/Profile', [
            'crumbs' => [
                ['label' => 'Profile'],
            ],
        ]);
    }
}
