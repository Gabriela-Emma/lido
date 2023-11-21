<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class NewsController extends PostController
{
    public function category(Request $request, Category $category): Factory|View|Application
    {
        $category->fastPaginate(10)->load(['Posts']);
        $section = 'Posts';

        return view('category')->with(compact('category', 'section'));
    }
}
