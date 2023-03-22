<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Fluent;
use Illuminate\Contracts\View\View;
use App\Repositories\PostRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\Foundation\Application;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;

class PostController extends Controller
{
    /**
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public function storeAudio(Request $request, Post $post)
    {
        $date = now('UTC')->format('Y-m-d-H:i:s');
        $locale = app()->getLocale();
        $post->addMediaFromRequest('media')
            ->usingFileName("{$post->slug}-$date-$locale")
            ->withCustomProperties(['mime-type' => 'audio/wav'])
            ->toMediaCollection('audio');

        return $post;
    }

    public function category(Request $request, Category $category)
    {
        $category->load(['posts']);
        $section = 'posts';

        return view('category')->with(compact('category', 'section'));
    }

    public function show(Request $request, PostRepository $postRepository, string $slug): Factory|View|Application
    {
        $post = $postRepository->get($slug);
        $post->load(['categories', 'tags']);

        $section = 'posts';

        return view('post')->with(compact('post', 'section'));
    }

    public function createReaction(Request $request, Post $post)
    {
        $validated = new Fluent($request->validate([
            'comment' => 'required',
        ]));
        $post->addLidoReaction($validated->comment, Auth::user());

        $post->save();

        return $post->fresh();
    }
}
