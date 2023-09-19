<?php

namespace App\Http\View\Composers;

use App\Models\Proposal;
use App\Repositories\CatalystGroupRepository;
use App\Repositories\FundRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Fluent;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CatalystGroupComposer
{
    private $catalystGroup;

    private $groupProposals;

    private $allTimeCaAverage;

    private $allTimeCaRatingCount;

    private $allTimeCaAverageGroups;

    private Fluent $allTimeFundingPerRound;

    private Fluent $allTimeCompletedPerRound;

    private Fluent $allTimeFundedPerRound;

    private Fluent $allTimeAwardedPerRound;

    private Fluent $allTimeReceivedPerRound;

    private Fluent $allTimeProposedPerRound;

    private ?Collection $wordCloudSet;

    private ?Collection $proposalChallenges;

    private $allDiscussions;

    private $discussionData;

    /**
     * Create a new profile composer.
     */
    public function __construct(
        protected CatalystGroupRepository $catalystGroupRepository,
        protected FundRepository $fundRepository
    ) {
        $this->catalystGroup = $this->catalystGroupRepository->get(request()->route('catalystGroup'));
        $this->groupProposals = $this->catalystGroup->proposals()->fastPaginate(
            $perPage = 16,
            $columns = ['*'],
            $pageName = 'proposals'
        );
        $this->setTagCloud();
        //

        $discussions = $this->catalystGroup?->proposals
            ->map(
                fn ($p) => $p->discussions
            )->collapse();
        $this->allDiscussions = $discussions;
        $this->discussionsRatings();
        // combined ratings across all CA reviews
        $ratings = $discussions->map(fn ($disc) => $disc->ratings)->collapse();
        $this->allTimeCaRatingCount = $ratings->count();
        $this->allTimeCaAverage = $ratings->avg('rating');
        // combined ratings by discussion
        $groups = $ratings->map(fn ($v) => ([
            'rating' => $v->rating,
            'review' => $v->model->title,
        ]))->groupBy('review')
            ->map(
                fn ($v, $k) => [
                    'rating' => round($v->avg('rating'), 2),
                    'percent' => intval(round($v->avg('rating') / 5 * 100)),
                ]
            );
        $this->allTimeCaAverageGroups = $groups;
        $proposalGroups = $this->fundRepository->funds('funds')->map(
            fn ($fund) => new Fluent([
                'fund' => $fund,
                'proposals' => $this->catalystGroup->proposals->filter(
                    fn ($p) => $p->fund->parent->id === $fund->id
                ),
            ])
        )->reverse();
        $labels = $proposalGroups->pluck('fund.title');
        $proposals = $proposalGroups->pluck('proposals');
        $usdProposals = collect($proposalGroups->toArray())->map(function ($item) {
            if ($item['fund']->currency === 'ADA') {
                $item['proposals'] = $item['proposals']->map(function ($p) {
                    return [];
                });
            }

            return $item;
        })->pluck('proposals');
        $adaProposals = collect($proposalGroups->toArray())->map(function ($item) {
            if ($item['fund']->currency === 'USD') {
                $item['proposals'] = $item['proposals']->map(function ($p) {
                    return [];
                });
            }

            return $item;
        })->pluck('proposals');

        $this->proposalChallenges = $this->catalystGroup->proposals
            ->map(fn ($p) => new Fluent([
                'proposal' => $p,
                'challenge' => Str::after($p->fund->label, ': '),
            ]))
            ->groupBy('challenge')
            ->map(fn ($cg) => new Fluent([
                'challenge' => $cg?->first()?->proposal?->fund,
                'proposals_count' => $cg?->pluck('proposal')->count(),
            ]))->sortByDesc('proposals_count');
        // ## Proposed
        $this->allTimeProposedPerRound = new Fluent([
            'labels' => $labels,
            'data' => $proposals->map(fn ($ps) => $ps->count()),
        ]);
        // ## Funded
        $this->allTimeFundedPerRound = new Fluent([
            'labels' => $labels,
            'data' => $proposals->map(
                fn ($ps) => $ps->countBy(fn ($p) => $p->funding_status)
            )->map(function ($g) {
                $complete = $g->get('complete') ?? 0;
                $funded = $g->get('funded') ?? 0;

                return $complete + $funded;
            })->values(),
        ]);
        // ## Completed
        $this->allTimeCompletedPerRound = new Fluent([
            'labels' => $labels,
            'data' => $proposals->map(
                fn ($ps) => $ps->countBy(fn ($p) => $p->status)
            )->map(fn ($g) => $g->get('complete') ?? 0)->values(),
        ]);
        // $$ Requested
        $this->allTimeFundingPerRound = new Fluent([
            'labels' => $labels,
            'dataUsd' => $usdProposals->map(
                fn ($ps) => $ps?->sum('amount_requested')
            )->values(),
            'dataAda' => $adaProposals->map(
                fn ($ps) => $ps?->sum('amount_requested')
            )->values(),
        ]);
        // $$ Awarded
        $this->allTimeAwardedPerRound = new Fluent([
            'labels' => $labels,
            'dataUsd' => $usdProposals->map(
                fn ($ps) => $ps?->filter(
                    fn ($p) => ($p instanceof Proposal && $p?->funded_at)
                )->sum('amount_requested')
            )->values(),
            'dataAda' => $adaProposals->map(
                fn ($ps) => $ps?->filter(
                    fn ($p) => ($p instanceof Proposal && $p?->funded_at)
                )->sum('amount_requested')
            )->values(),
        ]);

        //  $$ Received
        $this->allTimeReceivedPerRound = new Fluent([
            'labels' => $labels,
            'dataUsd' => $usdProposals->map(
                fn ($ps) => $ps?->sum('amount_received')
            )->values(),
            'dataAda' => $adaProposals->map(
                fn ($ps) => $ps?->sum('amount_received')
            )->values(),
        ]);
    }

    /**
     * Bind data to the view.
     */
    public function compose(View $view): void
    {
        $view->with(
            [
                'catalystGroup' => $this->catalystGroup,
                'groupProposals' => $this->groupProposals,
                'allTimeCaAverage' => $this->allTimeCaAverage,
                'allTimeCaRatingCount' => $this->allTimeCaRatingCount,
                'allTimeCaAverageGroups' => $this->allTimeCaAverageGroups,
                'allTimeFundedPerRound' => $this->allTimeFundedPerRound,
                'allTimeFundingPerRound' => $this->allTimeFundingPerRound,
                'allTimeAwardedPerRound' => $this->allTimeAwardedPerRound,
                'allTimeReceivedPerRound' => $this->allTimeReceivedPerRound,
                'allTimeProposedPerRound' => $this->allTimeProposedPerRound,
                'allTimeCompletedPerRound' => $this->allTimeCompletedPerRound,
                'proposalChallenges' => $this->proposalChallenges,
                'wordCloudSet' => $this->wordCloudSet,
                'discussionData' => $this->discussionData,
            ]
        );
    }

    protected function setTagCloud()
    {
        $this->wordCloudSet = Cache::remember("{$this->catalystGroup->slug}DetailsWordCloud", HOUR_IN_SECONDS, function () {
            $query = DB::select(
                <<<EOT
        select w.word, SUM(w.num_occurrences) as occurrences
        FROM
            (
                SELECT *
                FROM
                    "proposals"
                    INNER JOIN "catalyst_user_has_proposal" ON "catalyst_user_has_proposal"."proposal_id" = "proposals"."id"
                    INNER JOIN "catalyst_users" ON "catalyst_users"."id" = "catalyst_user_has_proposal"."catalyst_user_id"
                    INNER JOIN "catalyst_group_has_catalyst_user" ON "catalyst_group_has_catalyst_user"."catalyst_user_id" = "catalyst_users"."id"
                WHERE "catalyst_group_id" = {$this->catalystGroup?->id}
            ) t
          cross join lateral (
             select word, count(*) as num_occurrences
             from regexp_split_to_table(LOWER(t.content->>'en'), '[\s[:punct:]]+') as x(word)
             where word <> '' and word NOT IN (
                                               'on', 'in','is', 'that', 'this', 'through', 'these', 'which', 'for', 'the', 'his', 'it', 'http', 'while', 'those', '100', '000', 'any', 'key', 'what', 'per', 'has', 'there', 'been', 'and', 'be', 'are', 'by', 'com', 'their', 'an', 'or', 'to', 'of', 'de', 'as', 'at', 'if', 'so', 'will', 'https', 'please', 'provide', 'with'
                                              ) and LENGTH(word) > 4
             group by word
          ) w group by word ORDER BY occurrences DESC LIMIT 100;
        EOT
            );

            return collect($query);
        });
    }

    protected function discussionsRatings()
    {
        $discussionRatings = [];
        foreach ($this->allDiscussions as $discussion) {
            $title = $discussion['title'];
            $rating = $discussion->rating;
            if (! isset($discussionRatings[$title])) {
                $discussionRatings[$title] = [
                    'totalRating' => 0,
                    'totalCount' => 0,
                    'title' => $title,
                ];
            }
            if ($rating !== null) {
                $discussionRatings[$title]['totalRating'] += $rating;
                $discussionRatings[$title]['totalCount']++;
            }
        }
        foreach ($discussionRatings as $title => $data) {
            if ($data['totalCount'] > 0) {
                $averageRating = $data['totalRating'] / $data['totalCount'];
                $discussionRatings[$title]['averageRating'] = $averageRating;
            }
        }
        $this->discussionData = $discussionRatings;
    }
}
