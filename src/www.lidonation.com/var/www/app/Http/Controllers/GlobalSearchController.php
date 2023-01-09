<?php

namespace App\Http\Controllers;

use App\Models\Insight;
use App\Models\News;
use App\Models\Post;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use MeiliSearch\Endpoints\Indexes;

class GlobalSearchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  Request  $request
     * @param  string  $term
     * @return Response
     */
    public function index(Request $request, string $term): Response
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
}
