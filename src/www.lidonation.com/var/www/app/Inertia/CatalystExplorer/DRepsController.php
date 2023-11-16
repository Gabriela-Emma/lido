<?php

namespace App\Inertia\CatalystExplorer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DRepsController extends Controller
{
    public function index(Request $request)
    {
        return Inertia::render(
            'DReps',
            ['crumbs' => [['label' => 'dReps']]]
        );
    }
}
