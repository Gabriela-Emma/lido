<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Post;
use Inertia\Inertia;
use App\Models\Review;
use App\Models\Insight;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use MeiliSearch\Endpoints\Indexes;

class GlobalSearchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response
    {   
        $searchBuilder = Post::search($term,
            function (Indexes $index, $query, $options) {
                $options['filter'] = ' status = published';
                $options['limit'] = 30;

                return $index->search($query, $options);
            });
        $results = $searchBuilder->raw();
        if (! isset($results['hits'])) {
            return response([]);
        }
        $hits = collect($results['hits']);

        return response($hits->map(function ($hit) {
            $hit['type'] = match ($hit['type']) {
                News::class => 'news',
                Insight::class => 'insights',
                Review::class => 'reviews',
                default => 'posts',
            };

            return $hit;
        })->groupBy('type')
            ->map(function ($group, $key) {
                return [
                    'type' => $key,
                    'items' => $group,
                ];
            })->values());
    }

    public function newSearch(Request $request)
    {  
        $term = $request->input('q');
        if (!isset($term)){
            return null;
        }

        $searchBuilder = Post::search($term,
            function (Indexes $index, $query, $options) {
                $options['filter'] = ' status = published';
                $options['limit'] = 30;

                return $index->search($query, $options);
            });
        $results = $searchBuilder->raw();
        if (! isset($results['hits'])) {
            return response([]);
        }
        $hits = collect($results['hits']);

        return response($hits->map(function ($hit) {
            $hit['type'] = match ($hit['type']) {
                News::class => 'news',
                Insight::class => 'insights',
                Review::class => 'reviews',
                default => 'posts',
            };

            return $hit;
        })->groupBy('type')
            ->map(function ($group, $key) {
                return [
                    'type' => $key,
                    'items' => $group,
                ];
            })->values());
    }

    public function render(Request $request){
        return Inertia::render('GlobalSearch');
    } 
}
