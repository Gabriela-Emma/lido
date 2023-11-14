<?php

namespace App\Inertia\CatalystExplorer;

use App\Http\Controllers\Controller;
use App\Models\CatalystExplorer\Fund;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;

class HomeController extends Controller
{
    protected function setTagCloud()
    {
        $this->wordCloudSet = Cache::remember('catalystDetailsWordCloud', DAY_IN_SECONDS, function () {
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

    protected function setFundedAverage()
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
}
