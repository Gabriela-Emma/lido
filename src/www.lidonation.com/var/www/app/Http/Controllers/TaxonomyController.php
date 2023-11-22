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
        $category->load(['reviews']);
        $postsCount = $category->models->count();

        return view('category')
            ->with(compact('category', 'postsCount'))->withShortcodes();
    }

    public function tag(Request $request, Tag $tag): Factory|View|Application
    {
        $tag->load(['reviews']);

        return view('tag')
            ->with(compact('tag'))->withShortcodes();
    }
}
