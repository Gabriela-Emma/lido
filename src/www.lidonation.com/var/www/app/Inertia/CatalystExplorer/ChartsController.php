<?php

namespace App\Inertia\CatalystExplorer;

use App\Enums\CatalystExplorerQueryParams;
use App\Http\Controllers\Controller;
use App\Http\Resources\FundResource;
use App\Models\CatalystExplorer\CatalystSnapshot;
use App\Models\CatalystExplorer\CatalystUser;
use App\Models\CatalystExplorer\CatalystVotingPower;
use App\Models\CatalystExplorer\Fund;
use App\Models\CatalystExplorer\Proposal;
use App\Models\Meta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Fluent;
use Inertia\Inertia;
use Inertia\Response;
use JetBrains\PhpStorm\ArrayShape;
use Laravel\Scout\Builder;
use Meilisearch\Endpoints\Indexes;

class ChartsController extends Controller
{
    public mixed $fund;

    public mixed $largestFundedProposalObject;

    public mixed $fundedOver75KCount;

    public ?int $membersAwardedFundingCount;

    public ?int $completedProposalsCount;

    public ?int $fullyDisbursedProposalsCount;

    public $adaPowerRanges;

    public $votesRanges;

    public string $fundSlugFilter;

    public int|string $fundFilter = 113;

    public ?string $fundingStatus = null;

    public ?string $proposalStatus = null;

    public ?string $proposalType = null;

    public ?bool $fundedProposalsFilter;

    public ?string $sortBy = null;

    public ?string $sortOrder = null;

    public function metricLargestFundedProposalObject(Request $request)
    {
        $this->setFilters($request);
        $this->fundedProposalsFilter = true;
        $this->sortBy = 'amount_requested';
        $this->sortOrder = 'desc';
        $res = $this->query(false, ['link', 'amount_requested'], ['type = proposal'])->raw();

        if (isset($res['hits'])) {
            return collect($res['hits'])->first();
        }

        return null;
    }

    public function metricFundedOver75KCount(Request $request): ?int
    {
        $this->setFilters($request);
        $this->fundedProposalsFilter = true;
        $this->sortBy = 'amount_requested';
        $this->sortOrder = 'desc';
        $res = $this->query(false, ['amount_requested'], ['type = proposal', 'amount_requested >= 75000'])->raw();

        if (isset($res['hits'])) {
            return collect($res['hits'])->count();
        }

        return null;
    }

    public function metricMembersAwardedFundingCount(Request $request)
    {
        $this->setFilters($request);
        $this->fundedProposalsFilter = true;
        $this->sortBy = 'amount_requested';
        $this->sortOrder = 'desc';
        $res = $this->query(false, ['funded_at', 'fund_id', 'amount_requested'], ['type = proposal'])->raw();

        if ($this->fundFilter === CatalystExplorerQueryParams::ALL_FUNDS) {
            if (isset($res['hits'])) {
                return CatalystUser::whereHas(
                    'proposals',
                    function ($q) {
                        $q->whereNotNull('funded_at');
                    }
                )->count();
            } else {
                return null;
            }
        } else {
            $fundIds = (bool) $this->fundFilter ? DB::table('funds')->where('parent_id', $this->fundFilter)->pluck('id')
                : DB::table('funds')->where('parent_id', '>', 0)->pluck('id');

            if (isset($res['hits'])) {
                return CatalystUser::whereHas(
                    'proposals',
                    function ($q) use ($fundIds) {
                        $q->whereNotNull('funded_at')
                            ->where('fund_id', $fundIds->toArray())
                            ->orWhereIn('fund_id', $fundIds->toArray());
                    }
                )->count();
            } else {
                return null;
            }
        }
    }

    public function metricFullyDisbursedProposalsCount(Request $request): ?int
    {
        $this->setFilters($request);
        $this->fundedProposalsFilter = true;
        $res = $this->query(false, ['amount_requested', 'amount_received'], ['type = proposal'])->raw();
        if (isset($res['hits'])) {
            return collect($res['hits'])
                ->each(function ($proposal) {
                    if ($proposal['amount_requested'] == $proposal['amount_received'] && $proposal['amount_received'] > 0) {
                        return $proposal;
                    }
                })
                ->count();
        }

        return null;
    }

    public function metricCompletedProposalsCount(Request $request): ?int
    {
        $this->setFilters($request);
        $this->fundedProposalsFilter = true;
        $res = $this->query(false, ['id'], ['type = proposal', 'status = complete'])->raw();

        if (isset($res['hits'])) {
            return collect($res['hits'])
                ->count();
        }

        return null;
    }

    public function metricTotalRegisteredAdaPower(Request $request): float|int|null
    {
        $this->fundFilter = $request->input(CatalystExplorerQueryParams::FUNDS, 113);
        if ($this->fundFilter === CatalystExplorerQueryParams::ALL_FUNDS) {
            $votingPower = CatalystVotingPower::sum('voting_power');
        } else {
            $votingPower = CatalystVotingPower::whereRelation('catalyst_snapshot', 'model_id', $this->fundFilter)
                ->sum('voting_power');
        }

        if ($votingPower && $votingPower > 0) {
            return $votingPower / 1000000;
        }

        return null;
    }

    public function metricSumAdaRegisteredNotVoted(Request $request): float|int|null
    {
        $this->fundFilter = $request->input(CatalystExplorerQueryParams::FUNDS, 113);

        if ($this->fundFilter === CatalystExplorerQueryParams::ALL_FUNDS) {
            $sumAdaRegisteredNotVoted = CatalystVotingPower::where('consumed', 'f')->sum('voting_power');
        } else {
            $sumAdaRegisteredNotVoted = CatalystVotingPower::whereRelation('catalyst_snapshot', 'model_id', $this->fundFilter)
                ->where('consumed', 'f')
                ->sum('voting_power');
        }

        if ($sumAdaRegisteredNotVoted && $sumAdaRegisteredNotVoted > 0) {
            return $sumAdaRegisteredNotVoted / 1000000;
        }

        return null;
    }

    public function metricSumWalletsRegisteredNotVoted(Request $request): float|int|null
    {
        $this->fundFilter = $request->input(CatalystExplorerQueryParams::FUNDS, 113);

        if ($this->fundFilter === CatalystExplorerQueryParams::ALL_FUNDS) {
            $walletsRegisteredNotVoted = CatalystVotingPower::where('consumed', false)
                ->count('voter_id');
        } else {
            $walletsRegisteredNotVoted = CatalystVotingPower::whereRelation('catalyst_snapshot', 'model_id', $this->fundFilter)
                ->where('consumed', false)
                ->count('voter_id');
        }
        return $walletsRegisteredNotVoted ?? null;
    }

    public function metricTotalRegistrations(Request $request)
    {
        $this->fundFilter = $request->input(CatalystExplorerQueryParams::FUNDS, 113);
        if ($this->fundFilter === CatalystExplorerQueryParams::ALL_FUNDS) {
            $totalRegistrations = CatalystVotingPower::count();
        } else {
            $totalRegistrations = CatalystVotingPower::whereRelation('catalyst_snapshot', 'model_id', $this->fundFilter)
                ->count();
        }

        return $totalRegistrations ?? null;
    }

    public function metricTotalDelegationRegistrationsAdaPower(Request $request): float|int|null
    {
        $this->fundFilter = $request->input(CatalystExplorerQueryParams::FUNDS, 113);
        if ($this->fundFilter === CatalystExplorerQueryParams::ALL_FUNDS) {
            $votingPower = CatalystVotingPower::whereHas('delegations', operator: '>', count: 1)
                ->sum('voting_power');
        } else {
            $votingPower = CatalystVotingPower::whereHas('delegations', operator: '>', count: 1)
                ->whereHas('catalyst_snapshot', fn ($q) => $q->where('model_id', $this->fundFilter))
                ->sum('voting_power');
        }

        if ($votingPower && $votingPower > 0) {
            return $votingPower / 1000000;
        }

        return null;
    }

    public function metricsTotalYesVotes(Request $request): float|int|null
    {
        $p = Proposal::query();
        $this->setFilters($request);
        if ($this->fundFilter !== CatalystExplorerQueryParams::ALL_FUNDS) {
            if ($this->fundFilter) {
                $p->whereRelation('fund', 'parent_id', $this->fundFilter);
            }
        }

        return $p->sum('yes_votes_count');
    }

    public function metricsTotalNoVotes(Request $request): float|int|null
    {
        $p = Proposal::query();
        $this->setFilters($request);
        if ($this->fundFilter !== CatalystExplorerQueryParams::ALL_FUNDS) {
            if ($this->fundFilter) {
                $p->whereRelation('fund', 'parent_id', $this->fundFilter);
            }
        }

        return $p->sum('no_votes_count');
    }

    public function metricTotalDelegationRegistrations(Request $request)
    {
        $this->fundFilter = $request->input(CatalystExplorerQueryParams::FUNDS, 113);

        if ($this->fundFilter === CatalystExplorerQueryParams::ALL_FUNDS) {
            return CatalystVotingPower::whereHas('delegations', operator: '>', count: 1)
                ->count();
        }

        return CatalystVotingPower::whereHas('delegations', operator: '>', count: 1)
            ->whereHas('catalyst_snapshot', fn ($q) => $q->where('model_id', $this->fundFilter))
            ->count();
    }

    public function metricAdaPowerRanges(Request $request): Fluent
    {
        $this->setFilters($request);

        $this->setSnapshotStats();

        $powersResults = [];

        foreach ($this->adaPowerRanges as $key => $power) {
            $powersResults[] = new Fluent([
                'key' => $key,
                'count' => $power['0'],
                'total' => $power['1'],
            ]);
        }

        return new Fluent($powersResults);
    }

    public function metricVotesCastAverage(Request $request): ?int
    {
        $this->setFilters($request);
        $totalVotedQuery = CatalystVotingPower::where('consumed', true);
        if ($this->fundFilter !== CatalystExplorerQueryParams::ALL_FUNDS) {
            $totalVotedQuery->whereRelation('catalyst_snapshot', 'model_id', $this->fundFilter);
        }

        $avg = $totalVotedQuery->avg('votes_cast');

        return $avg ? intval(number_format($avg, 2)) : null;
    }

    public function metricVotesCastMode(Request $request): ?int
    {
        $this->setFilters($request);
        $modeQuery = CatalystVotingPower::select(
            DB::raw('mode() WITHIN GROUP (ORDER BY votes_cast) AS mode')
        )->where('consumed', 1);

        if ($this->fundFilter !== CatalystExplorerQueryParams::ALL_FUNDS) {
            $modeQuery->whereRelation('catalyst_snapshot', 'model_id', $this->fundFilter);
        }

        $res = DB::select($modeQuery->toSql(), $modeQuery->getBindings());
        if (! empty($res)) {
            return intval($res[0]->mode);
        }

        return null;
    }

    public function metricVotesCastMedian(Request $request): ?int
    {
        $this->setFilters($request);
        $modeQuery = CatalystVotingPower::select(
            DB::raw('PERCENTILE_CONT(0.5) WITHIN GROUP (ORDER BY votes_cast) AS median')
        )->where('consumed', 1);

        if ($this->fundFilter !== CatalystExplorerQueryParams::ALL_FUNDS) {
            $modeQuery->whereRelation('catalyst_snapshot', 'model_id', $this->fundFilter);
        }

        $res = DB::select($modeQuery->toSql(), $modeQuery->getBindings());
        if (! empty($res)) {
            return intval($res[0]->median);
        }

        return null;
    }

    public function metricTotalRegisteredAndVoted(Request $request)
    {
        $this->setFilters($request);
        $totalVotedQuery = CatalystVotingPower::where('consumed', 1);
        if ($this->fundFilter !== CatalystExplorerQueryParams::ALL_FUNDS) {
            $totalVotedQuery->whereRelation('catalyst_snapshot', 'model_id', $this->fundFilter);
        }

        return $totalVotedQuery->count() ?? null;
    }

    public function metricTotalRegisteredAndNeverVoted(Request $request)
    {
        $this->setFilters($request);
        $totalVotedQuery = CatalystVotingPower::where('consumed', false);
        if ($this->fundFilter !== CatalystExplorerQueryParams::ALL_FUNDS) {
            $totalVotedQuery->whereRelation('catalyst_snapshot', 'model_id', $this->fundFilter);
        }

        return $totalVotedQuery->count() ?? null;
    }

    public function metricVotesCastRanges(Request $request): Fluent
    {
        $this->setFilters($request);

        $this->setVotesCastedStats();

        $votesResults = [];

        foreach ($this->votesRanges as $key => $power) {
            $votesResults[] = new Fluent([
                'key' => $key,
                'count' => $power['0'],
                'total' => $power['1'],
            ]);
        }

        return new Fluent($votesResults);
    }

    public function index(Request $request): Response
    {
        $this->setFilters($request);

        $funds = CatalystSnapshot::with('model')
            ->where('model_type', Fund::class)
            ->orderBy('snapshot_at', 'desc')
            ->get()->map(fn ($cs) => $cs->model);

        $challenges = Fund::where('parent_id', '=', 113)->get(['id', 'title']);

        $props = [
            'funds' => FundResource::collection($funds)->toArray($request),
            'challenges' => FundResource::collection($challenges)->toArray($request),
            'filters' => [
                'fundId' => $this->fundFilter,
            ],
            'crumbs' => [
                [
                    'label' => 'Funds',
                    'link' => route('catalyst-explorer.funds.index'),
                ],
                [
                    'label' => 'Proposals',
                    'link' => route('catalyst-explorer.proposals'),
                ],
                ['label' => 'Catalyst by the Numbers'],
            ],
            'locale' => app()->getLocale(),
        ];

        return Inertia::render('Charts', $props);
    }

    protected function setFilters(Request $request): void
    {
        $this->fundFilter = $request->input(CatalystExplorerQueryParams::FUNDS, 113);

        if ($this->fundFilter === CatalystExplorerQueryParams::ALL_FUNDS) {
            $this->fund = null;

            return;
        }

        $this->fund = ! is_null($this->fundFilter)
            ? Fund::where('id', $this->fundFilter)->first()
            : null;
    }

    protected function query($returnBuilder = false, $attrs = null, $filters = []): Fluent|Builder
    {
        $_options = [
            'filters' => array_merge([], $this->getUserFilters(), $filters),
        ];

        $searchBuilder = Proposal::search(
            null,
            function (Indexes $index, $query, $options) use ($_options, $attrs) {
                if (count($_options['filters']) > 0) {
                    $options['filter'] = implode(' AND ', $_options['filters']);
                }

                $options['attributesToRetrieve'] = $attrs ?? [
                    'id',
                    'amount_requested',
                    'amount_received',
                    'currency',
                    'ca_rating',
                    'ratings_count',
                    'slug',
                    'title',
                    'funding_status',
                    'groups.id',
                    'ideascale_link',
                    'yes_votes_count',
                    'no_votes_count',
                    'opensource',
                    'paid',
                    'problem',
                    'project_length',
                    'quickpitch',
                    'solution',
                    'status',
                    'website',
                    'type',
                    'ranking_total',
                    'users.id',
                    'users.name',
                    'users.username',
                    'users.ideascale_id',
                    'users.media.original_url',
                    'users.profile_photo_url',
                    'fund.id',
                    'fund.label',
                    'fund.amount',
                    'fund.status',
                    'challenge.id',
                    'challenge.label',
                    'challenge.amount',
                ];

                if ((bool) $this->sortBy && (bool) $this->sortOrder) {
                    $options['sort'] = ["$this->sortBy:$this->sortOrder"];
                }

                $options['offset'] = 0;
                $options['limit'] = 1000000;

                return $index->search($query, $options);
            }
        );

        if ($returnBuilder) {
            return $searchBuilder;
        }

        return new Fluent($searchBuilder->raw());
    }

    protected function setVotesCastedStats(): void
    {
        $fundIds = $this->getFundIds();

        $snapshotIds = DB::table('catalyst_snapshots')
            ->whereIn('model_id', $fundIds)
            ->where('model_type', Fund::class)
            ->pluck('id');

        $agg = DB::table('catalyst_voting_powers')
            ->selectRaw(
                "CASE
                WHEN votes_cast BETWEEN 0 AND 1 THEN '0-1-1'
                WHEN votes_cast BETWEEN 2 AND 10 THEN '2-10-2'
                WHEN votes_cast BETWEEN 11 AND 25 THEN '11-25-3'
                WHEN votes_cast BETWEEN 26 AND 50 THEN '26-50-4'
                WHEN votes_cast BETWEEN 51 AND 150 THEN '51-150-5'
                WHEN votes_cast BETWEEN 151 AND 300 THEN '151-300-6'
                WHEN votes_cast BETWEEN 301 AND 600 THEN '301-600-7'
                WHEN votes_cast BETWEEN 601 AND 900 THEN '601-900-8'
                WHEN votes_cast > 900 THEN '> 900-9'
                END as range,  COUNT(*) as proposals, SUM(voting_power) as voting_power"
            )->whereIn('catalyst_snapshot_id', $snapshotIds)
            ->where('votes_cast', '>', 0)
            ->groupByRaw(1);

        $votesRangesCollection = $agg->get()
            ->map(fn ($row) => [$row->range => [$row->proposals, $row->voting_power / 1000000]])
            ->collapse();

        // convert the collection to an associative array whose structure is fully representative of our front-end needs
        $votesRangesFormattedArray = [];
        foreach ($votesRangesCollection as $range => $value) {
            $rangeArray = explode('-', $range);
            $finalRange = $rangeArray[0].(count($rangeArray) == 3 ? ' - '.$rangeArray[1] : '');

            $votesRangesFormattedArray[$finalRange] = [
                $value['0'],
                $value['1'],
                intval(isset($rangeArray['2']) ? $rangeArray['2'] : $rangeArray['1']),
            ];
        }

        $this->votesRanges = collect($votesRangesFormattedArray)
            ->sortBy(function ($value, $key) {
                return $value[count($value) - 1];
            });
    }

    protected function setSnapshotStats(): void
    {
        if ($this->fundFilter === CatalystExplorerQueryParams::ALL_FUNDS) {
            $fundIds = CatalystSnapshot::query()
                ->where('model_type', Fund::class)
                ->pluck('model_id')
                ->toArray();
        } else {
            $fundIds = $this->fund
                ? [$this->fund?->id]
                : CatalystSnapshot::query()
                    ->where('model_type', Fund::class)
                    ->pluck('model_id')
                    ->toArray();
        }

        $snapshotIds = CatalystSnapshot::whereIn('model_id', $fundIds)
            ->where('model_type', Fund::class)
            ->pluck('id');

        $agg = DB::table('catalyst_voting_powers')
            ->selectRaw(
                "CASE
                WHEN voting_power BETWEEN 450000000 AND 1000000000 THEN '450-1k-1'
                WHEN voting_power BETWEEN 1000000000 AND 5000000000 THEN '1k-5k-2'
                WHEN voting_power BETWEEN 5000000000 AND 10000000000 THEN '5K-10k-3'
                WHEN voting_power BETWEEN 10000000000 AND 25000000000 THEN '10K-25k-4'
                WHEN voting_power BETWEEN 25000000000 AND 50000000000 THEN '25k-50k-5'
                WHEN voting_power BETWEEN 50000000000 AND 75000000000 THEN '50k-75k-6'
                WHEN voting_power BETWEEN 75000000000 AND 100000000000 THEN '75k-100k-7'
                WHEN voting_power BETWEEN 100000000000 AND 250000000000 THEN '100k-250k-8'
                WHEN voting_power BETWEEN 250000000000 AND 500000000000 THEN '250k-500k-9'
                WHEN voting_power BETWEEN 500000000000 AND 750000000000 THEN '500k-750k-10'
                WHEN voting_power BETWEEN 750000000000 AND 1000000000000 THEN '750k-1M-11'
                WHEN voting_power BETWEEN 1000000000000 AND 5000000000000 THEN '1M-5M-12'
                WHEN voting_power BETWEEN 5000000000000 AND 10000000000000 THEN '5M-10M-24'
                WHEN voting_power BETWEEN 10000000000000 AND 15000000000000 THEN '10M-15M-27'
                WHEN voting_power BETWEEN 15000000000000 AND 21000000000000 THEN '15M-21M-29'
                WHEN voting_power BETWEEN 21000000000000 AND 30000000000000 THEN '21M-30M-30'
                WHEN voting_power BETWEEN 30000000000000 AND 45000000000000 THEN '30M-45M-31'
                WHEN voting_power BETWEEN 45000000000000 AND 75000000000000 THEN '45M-75M-32'
                WHEN voting_power BETWEEN 75000000000000 AND 100000000000000 THEN '75M-100M-33'
                WHEN voting_power > 100000000000000 THEN '> 100M-34'
                END as range,  COUNT(*) as wallets, SUM(voting_power) as ada"
            )->whereIn('catalyst_snapshot_id', $snapshotIds)
            ->where('voting_power', '>=', 450000000)
            ->groupByRaw(1);

        $adaPowerRangesCollection = $agg->get()
            ->map(fn ($row) => [$row->range => [$row->wallets, $row->ada]])
            ->collapse();

        // convert the collection to an associative array whose structure is fully representative of our front-end needs
        $adaPowerRangesFormattedArray = [];
        foreach ($adaPowerRangesCollection as $range => $value) {
            $rangeArray = explode('-', $range);
            $finalRange = $rangeArray[0].(count($rangeArray) == 3 ? ' - '.$rangeArray[1] : '');

            $adaPowerRangesFormattedArray[$finalRange] = [
                $value['0'],
                round($value['1'] / 1000000, 2),
                intval(isset($rangeArray['2']) ? $rangeArray['2'] : $rangeArray['1']),
            ];
        }

        // convert then order the array to collection and assing to the objects $adaPowerRanges property
        $this->adaPowerRanges = collect($adaPowerRangesFormattedArray)
            ->sortBy(function ($value, $key) {
                return $value[count($value) - 1];
            });
    }

    #[ArrayShape(['filters' => 'array'])]
    protected function getUserFilters(): array
    {
        $_options = [];

        if ((bool) $this->fundingStatus && $this->fundingStatus !== 'paid') {
            $_options[] = "funding_status = {$this->fundingStatus}";
        }

        if ((bool) $this->proposalStatus) {
            $_options[] = "status = {$this->proposalStatus}";
        }

        if ((bool) $this->proposalType) {
            $_options[] = "type = {$this->proposalType}";
        }

        if ((bool) $this->fundedProposalsFilter) {
            $_options[] = "funded = {$this->fundedProposalsFilter}";
        }

        // filter by fund
        if ($this->fundFilter !== CatalystExplorerQueryParams::ALL_FUNDS) {
            $_options[] = "fund.id = {$this->fundFilter}";
        }

        return $_options;
    }

    public function getTopFundedProposals(Request $request)
    {
        $param = $request->input(CatalystExplorerQueryParams::FUNDS, 113);
        $query = Proposal::with(['users', 'groups'])
            ->when($param !== CatalystExplorerQueryParams::ALL_FUNDS,
                function ($query) use ($param) {
                    $query->whereRelation('fund.parent', 'id', $param);
                }
            )
            ->where(['proposals.type' => 'proposal'])
            ->orderByDesc('amount_requested')
            ->when($request->input(CatalystExplorerQueryParams::CHART_FUND_STATUS) == 1,
                function ($query) {
                    $query->whereNotNull('funded_at');
                }
            )
            ->limit(15);

        return $query->get();
    }

    public function getTopFundedTeams(Request $request)
    {
        $fund = $request->input(CatalystExplorerQueryParams::FUNDS, null);
        $fundedStatus = $request->input(CatalystExplorerQueryParams::CHART_FUND_STATUS);

        if ($fund === CatalystExplorerQueryParams::ALL_FUNDS) {
            $fund = null;
        }

        $users = CatalystUser::with('groups')
            ->whereHas(
                'proposals',
                function ($q) use ($fund, $fundedStatus) {
                    $q->when($fundedStatus == 1,
                        function ($q) {
                            $q->whereNotNull('funded_at');
                        })
                        ->when(
                            $fund,
                            function ($q, $fund) {
                                $q->whereRelation('fund.parent', 'id', $fund);
                            }
                        );
                }
            )
            ->withSum([
                'proposals as amount_requested' => function ($query) use ($fund, $fundedStatus) {
                    $query->when($fundedStatus == 1,
                        function ($q) {
                            $q->whereNotNull('funded_at');
                        })->when(
                        $fund,
                        function ($query, $param) {
                            $query->whereRelation('fund.parent', 'id', $param);
                        }
                    );
                },
            ], 'amount_requested')
            ->orderBy('amount_requested', 'desc')
            ->limit(100)
            ->get();

        $groupedUsers = $users->filter(function ($user) {
            return ! is_null($user->groups->first());
        })->groupBy(function ($user) {
            return $user->groups->first()->id;
        });

        $groupedUsers = $groupedUsers->map(function ($group) {
            return $group->sortByDesc('amount_requested')->values();
        });

        $ungroupedUsers = $groupedUsers->map(function ($group) {
            return $group->first();
        });

        $finalUsers = $ungroupedUsers->concat($users->filter(function ($user) {
            return is_null($user->groups->first());
        }))->sortByDesc('amount_requested')->values()->all();

        return [
            'fund' => Fund::find($fund),
            'proposers' => array_slice($finalUsers, 0, 21),
        ];
    }

    protected function getFundIds()
    {
        if ($this->fundFilter === CatalystExplorerQueryParams::ALL_FUNDS) {
            $fundIds = DB::table('catalyst_snapshots')
                ->where('model_type', Fund::class)
                ->pluck('model_id')
                ->toArray();
        } else {
            $fundIds = $this->fund
                ? [$this->fund?->id]
                : DB::table('catalyst_snapshots')
                    ->where('model_type', Fund::class)
                    ->pluck('model_id')
                    ->toArray();
        }

        return $fundIds;
    }

    protected function attachmentLink(Request $request)
    {
        $snapshot = CatalystSnapshot::where('model_type', Fund::class)
            ->where('model_id', $request->input('fs'))
            ->first();

        $link = Meta::where('model_type', CatalystSnapshot::class)
            ->where('model_id', $snapshot->id)
            ->where('key', 'snapshot_file_path')
            ->first();

        if (! $link) {
            return null;
        }

        return '/storage/'.$link?->content;
    }
}
