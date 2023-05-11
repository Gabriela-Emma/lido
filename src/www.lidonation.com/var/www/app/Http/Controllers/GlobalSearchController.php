<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Post;
use App\Models\Review;
use App\Models\Insight;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use MeiliSearch\Endpoints\Indexes;
use App\DataTransferObjects\PostData;
use App\DataTransferObjects\PostSearchResultData;

class GlobalSearchController extends Controller
{
    public $inputTerm;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, string $term=null)
    {  
        $this->inputTerm = $request->input('q');
        if(isset($inputTerm)){
            $term = $inputTerm;
        }
        $searchBuilder = Post::search($term,
            function (Indexes $index, $query, $options) {
                $options['filter'] = ' status = published';
                $options['limit'] = 30;

                return $index->search($query, $options);
            }
        );
        $results = $searchBuilder->raw();
        if (!isset($results['hits'])) {
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
                return PostSearchResultData::from([
                    'type' => $key,
                    'items' => isset($this->inputTerm) ? $group :$group->take(5),
                ]);
            })->values());
    }

}
