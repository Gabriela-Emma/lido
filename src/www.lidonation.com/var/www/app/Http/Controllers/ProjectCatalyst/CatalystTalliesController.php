<?php

namespace App\Http\Controllers\ProjectCatalyst;

use App\Http\Controllers\Controller;
use App\Models\CatalystTally;
use Illuminate\Http\Request;

class CatalystTalliesController extends Controller
{
    public function index(Request $request) {
        $perPage = $request->input('pp', 24);
        $page = $request->input('p', 1);
        $order = $request->input('o', 'asc');
        $orderBy = $request->input('ob', 'tally');

        return CatalystTally::orderBy($orderBy, $order)
        ->fastPaginate($perPage, ['*'], 'page', $page);
    }
}
