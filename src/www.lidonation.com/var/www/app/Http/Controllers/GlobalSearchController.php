<?php

namespace App\Http\Controllers;

use App\DataTransferObjects\PostSearchResultData;
use App\Models\Insight;
use App\Models\News;
use App\Models\Post;
use App\Models\Review;
use Illuminate\Http\Request;
use MeiliSearch\Endpoints\Indexes;

class GlobalSearchController extends Controller
{
    public $inputTerm;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, string $term = null)
    {
        $this->inputTerm = $request->input('q');
        if (isset($this->inputTerm)) {
            $term = $this->inputTerm;
        }
        $searchBuilder = Post::search($term,
            function (Indexes $index, $query, $options) {
                $options['filter'] = ' status = published';
                $options['limit'] = 30;

                return $index->search($query, $options);
            }
        );
        $results = $searchBuilder->raw();
        if (! isset($results['hits'])) {
            return response([]);
        }
        $hits = collect($results['hits']);

        return response($hits->map(function ($hit) {
            $hit['type'] = match ($hit['type']) {
                Post::class => 'articles',
                Insight::class => 'insights',
                Review::class => 'reviews',
                default => 'posts',
            };

            return $hit;
        })->groupBy('type')
            ->map(function ($group, $key) {
                return PostSearchResultData::from([
                    'type' => $key,
                    'items' => $group,
                ]);
            })->values());
    }
}
