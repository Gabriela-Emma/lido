<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class ReviewsController extends Controller
{
    public function category(Request $request, Category $category)
    {
        $category->load(['reviews']);
        $section = 'reviews';

        return view('category')->with(compact('category', 'section'));
    }
}
