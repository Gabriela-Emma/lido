<?php

namespace App\Http\Controllers\Api\CatalystExplorer;

use App\Http\Controllers\Controller;
use \Illuminate\Http\Request;

class ReportController extends Controller
{
    public function follow(Request $request)
    {
        $validated = $request->validate([
            'where' => 'email:rfc,dns',
            'body' => 'required',
        ]);

    }

}
