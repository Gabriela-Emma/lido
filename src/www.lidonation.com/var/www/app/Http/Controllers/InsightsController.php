<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class InsightsController extends Controller
{
    public function category(Request $request, Category $category)
    {
        $category->load(['insights']);
        $section = 'insights';

        return view('category')->with(compact('category', 'section'));
    }
}
