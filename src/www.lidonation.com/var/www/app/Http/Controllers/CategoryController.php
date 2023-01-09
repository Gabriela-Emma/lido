<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request, Category $category)
    {
        $category->load(['reviews', 'news', 'insights']);

        return view('category')->with(compact('category'));
    }
}
