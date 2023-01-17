<?php

namespace App\Http\Controllers\ProjectCatalyst;

use App\Http\Controllers\Controller;
use Inertia\Inertia;

class CatalystReportsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render('Reports', [
            'crumbs' => [
                ['label' => 'Reports'],
            ],
        ]);
    }
}
