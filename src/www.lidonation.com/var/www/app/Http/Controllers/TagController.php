<?php

namespace App\Http\Controllers;

use App\Models\Taxonomy;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function load(Request $request, Taxonomy $tax)
    {
        return view('category');
    }
}
