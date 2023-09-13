<?php

namespace App\Http\Controllers\ProjectCatalyst;

use App\Enums\CatalystExplorerQueryParams;
use App\Http\Controllers\Controller;
use App\Http\Resources\FundResource;
use App\Models\CatalystSnapshot;
use App\Models\CatalystUser;
use App\Models\Fund;
use App\Models\Meta;
use App\Models\Proposal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Fluent;
use Inertia\Inertia;
use JetBrains\PhpStorm\ArrayShape;
use Meilisearch\Endpoints\Indexes;

class CatalystChartsController extends Controller
{
    public mixed $fund;

    public mixed $largestFundedProposalObject;

    public mixed $fundedOver75KCount;

    public ?int $membersAwardedFundingCount;

    public ?int $completedProposalsCount;

    public ?int $fullyDisbursedProposalsCount;

    public $adaPowerRanges;

    public string $fundSlugFilter;

    public ?int $fundFilter = 113;

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
        $res = $this->query(false, ['link', 'amount_requested'])->raw();

        if (isset($res['hits'])) {
            return collect($res['hits'])->first();
        }

        return null;
    }

    public function metricFundedOver75KCount(Request $request)
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

        $fundIds = (bool) $this->fundFilter ? DB::table('funds')->where('parent_id', $this->fundFilter)->pluck('id')
            : DB::table('funds')->where('parent_id', '>', 0)->pluck('id');

        if (isset($res['hits'])) {
            return CatalystUser::whereHas('proposals',
                function ($q) use ($fundIds) {
                    $q->whereNotNull('funded_at')
                        ->where('fund_id', $fundIds->toArray())
                        ->orWhereIn('fund_id', $fundIds->toArray());
                })
                ->count();
        } else {
            return null;
        }
    }

    public function metricFullyDisbursedProposalsCount(Request $request)
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

    public function metricCompletedProposalsCount(Request $request)
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

    public function metricAdaPowerRanges(Request $request)
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

    public function index(Request $request)
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
        ];

        return Inertia::render('Charts', $props);
    }

    protected function setFilters(Request $request)
    {
        $this->fundFilter = $request->input(CatalystExplorerQueryParams::FUNDS, 113);

        $this->fund = ! is_null($this->fundFilter)
            ? Fund::where('id', $this->fundFilter)->first()
            : null;
    }

    protected function query($returnBuilder = false, $attrs = null, $filters = [])
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

    protected function setSnapshotStats()
    {
        $fundIds = $this->fund
            ? [$this->fund?->id]
            : CatalystSnapshot::query()->where('model_type', Fund::class)
                ->pluck('model_id')
                ->toArray();

        $snapshotIds = CatalystSnapshot::whereIn('model_id', $fundIds)
            ->where('model_type', Fund::class)
            ->pluck('id');

        $agg = DB::table('catalyst_voting_powers')
            ->selectRaw("CASE
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
        if ((int) $this->fundFilter) {
            $_options[] = "fund.id = {$this->fundFilter}";
        }

        return $_options;
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
