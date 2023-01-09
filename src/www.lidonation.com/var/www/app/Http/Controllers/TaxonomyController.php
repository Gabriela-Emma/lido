<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Tag;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class TaxonomyController extends PostController
{
    public function category(Request $request, Category $category): Factory|View|Application
    {
        $category->load(['news', 'reviews', 'insights']);
        $postsCount = $category->models->count();
        return view('category')
            ->with(compact('category', 'postsCount'));
    }

    public function tag(Request $request, Tag $tag): Factory|View|Application
    {
        $tag->load(['news', 'reviews', 'insights']);

        return view('tag')
            ->with(compact('tag'));
    }
}
