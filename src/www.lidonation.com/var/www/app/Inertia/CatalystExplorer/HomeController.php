<?php

namespace App\Inertia\CatalystExplorer;

use AllowDynamicProperties;
use App\Http\Controllers\Controller;
use App\Models\CatalystExplorer\Fund;
use App\Models\Post;
use App\Models\Tag;
use App\Repositories\PostRepository;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;

#[AllowDynamicProperties] class HomeController extends Controller
{
    protected function setTagCloud(): void
    {
        $this->wordCloudSet = Cache::remember('catalystDetailsWordCloud', 86400, function () {
            $query = DB::select(<<<EOT
        select w.word, SUM(w.num_occurrences) as occurrences
        from proposals t
          cross join lateral (
             select word, count(*) as num_occurrences
             from regexp_split_to_table(LOWER(t.content->>'en'), '[\s[:punct:]]+') as x(word)
             where word <> '' and word NOT IN (
                                               'on', 'in','is', 'that', 'this', 'through', 'these', 'which', 'for', 'the', 'his', 'it', 'http', 'while', 'those', '100', '000', 'any', 'key', 'what', 'per', 'has', 'there', 'been', 'and', 'be', 'are', 'by', 'com', 'their', 'an', 'or', 'to', 'of', 'de', 'as', 'at', 'if', 'so', 'will', 'https', 'with'
                                              ) and LENGTH(word) > 4
             group by word
          ) w group by word ORDER BY occurrences DESC LIMIT 260;
        EOT
            );

            return collect($query);
        });
    }

    protected function setFundedAverage(): void
    {
        $funds = Fund::funds()->withOnly(['proposals'])
            ->withCount([
                'parent_proposals as proposals_count_amount_requested' => function ($query) {
                    $query->whereNotNull('funded_at')->where('proposals.type', 'proposal');
                }, ],
                'amount_requested'
            )
            ->withAvg([
                'parent_proposals as proposals_avg_amount_requested' => function ($query) {
                    $query->whereNotNull('funded_at')->where('proposals.type', 'proposal');
                }, ],
                'amount_requested'
            )->orderBy('launched_at')
            ->get();
        $this->fundedAverageSet = $funds->map(fn ($p) => [
            'label' => $p->title,
            'avg' => $p->proposals_avg_amount_requested,
            'count' => $p->proposals_count_amount_requested,
        ])->filter(fn ($p) => $p['avg'] > 0);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        return Inertia::render('Home', [
            'crumbs' => [],
        ]);
    }

    public function getCatalystPost(PostRepository $posts)
    {
        $tag = Tag::where('slug', 'project-catalyst')->first();
        Post::withoutGlobalScopes();
        $catalystPosts = $posts->inTaxonomies(Tag::class, $tag)
            ->getQuery()
            ->latest('published_at')
            ->limit(4)
            ->get()
            ->take(4);

        // Extracting necessary attributes from each post
        return $catalystPosts->map(function ($post) {
            return [
                'title' => $post->title,
                'subtitle' => $post->subtitle,
                'image' => $post->getFirstMediaUrl('hero'),
                'author' => $post->author->name,
                'author_gravatar' => $post->author->gravatar,
                'published_at' => $post->published_at->format('M d, Y'),
            ];
        });
    }
}
