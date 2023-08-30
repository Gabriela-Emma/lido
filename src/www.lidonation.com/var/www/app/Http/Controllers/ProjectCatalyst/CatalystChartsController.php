<?php

namespace App\Http\Controllers\ProjectCatalyst;

use App\Enums\CatalystExplorerQueryParams;
use App\Http\Controllers\Controller;
use App\Models\CatalystSnapshot;
use App\Models\CatalystUser;
use App\Models\CatalystVotingPower;
use App\Models\Fund;
use App\Models\Proposal;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use JetBrains\PhpStorm\ArrayShape;

class CatalystChartsController extends Controller
{
    public string|null $fundFilter;

    public Fund|null $fund;

    public Proposal|null $largestFundedProposalObject;

    public int|null $fundedOver75KCount;

    public int|null $membersAwardedFundingCount;

    public int|null $completedProposalsCount;

    public int|null $fullyDisbursedProposalsCount;

    public $adaPowerRanges;

    public function index(Request $request)
    {
        $this->setFilters($request);

        $this->setFund();

        $this->setProposalsStats();

        $this->setSnapshotStats();

        $props = [
            'adaPowerRanges' => $this->adaPowerRanges,
            'largestFundedProposalObject' => $this->largestFundedProposalObject,
            'fundedOver75KCount' => $this->fundedOver75KCount ?? 0,
            'membersAwardedFundingCount' => $this->membersAwardedFundingCount ?? 0,
            'fullyDisbursedProposalsCount' => $this->fullyDisbursedProposalsCount ?? 0,
            'completedProposalsCount'  => $this->completedProposalsCount ?? 0,
            'filters' => [
                'fund' => $this->fundFilter,
                ]
            ];

            return Inertia::render('Charts', $props);
    }

    protected function setFilters(Request $request)
    {
        $this->fundFilter = $request->input(CatalystExplorerQueryParams::FUNDS, null);
    }

    protected function setFund()
    {
        $this->fund = !is_null($this->fundFilter)
            ? Fund::where('slug', $this->fundFilter)->first()
            : null;
    }

    protected function setProposalsStats()
    {
        $fundIds = $this->fund?->fundChallenges()->pluck('id')
            ?? Proposal::query()->pluck('fund_id')->unique();

        $proposalIds = !is_null($this->fund)
            ? Proposal::whereIn('fund_id', $this->fund->fundChallenges()->pluck('id'))->pluck('id')
            : Proposal::query()->pluck('id');

        $this->largestFundedProposalObject = Proposal::whereIn('id', $proposalIds)
            ->where('proposals.type', 'proposal')
            ->whereNotNull('funded_at')
            ->orderByDesc('amount_requested')
            ->first();

        $this->fundedOver75KCount = Proposal::whereIn('id', $proposalIds)
            ->where('proposals.type', 'proposal')
            ->whereNotNull('funded_at')
            ->where('amount_requested', '>=', 75000)
            ->count();

        $this->membersAwardedFundingCount = CatalystUser::whereHas('proposals',
            function ($q) use($fundIds) {
                return $q->whereNotNull('funded_at')
                    ->whereIn('fund_id', $fundIds->toArray());
            })
            ->count();

        $this->fullyDisbursedProposalsCount = Proposal::whereIn('id', $proposalIds)
            ->where('proposals.type', 'proposal')
            ->whereNotNull('funded_at')
            ->whereColumn('amount_requested', '=', 'amount_received')
            ->count();

        $this->completedProposalsCount = Proposal::whereIn('id', $proposalIds)
            ->where('proposals.type', 'proposal')
            ->where('status', 'complete')
            ->count();

    }

    protected function setSnapshotStats()
    {
        $fundIds = $this->fund
            ? [$this->fund?->id]
            : CatalystSnapshot::query()->where('model_type', Fund::class)->pluck('model_id')->toArray();

        $snapshotIds = CatalystSnapshot::with('votingPowers')
            ->whereIn('model_id', $fundIds)
            ->where('model_type', Fund::class)
            ->pluck('id');

        $agg = DB::table('catalyst_voting_powers')
            ->selectRaw("CASE
                WHEN voting_power BETWEEN 5000000 AND 10000000 THEN '5-10-1'
                WHEN voting_power BETWEEN 10000000 AND 100000000 THEN '10-100-2'
                WHEN voting_power BETWEEN 100000000 AND 500000000 THEN '100-500-3'
                WHEN voting_power BETWEEN 500000000 AND 1000000000 THEN '500-1k-4'
                WHEN voting_power BETWEEN 1000000000 AND 2500000000 THEN '1k-2.5k-5'
                WHEN voting_power BETWEEN 2500000000 AND 5000000000 THEN '2.5k-5k-6'
                WHEN voting_power BETWEEN 5000000000 AND 10000000000 THEN '5K-10k-7'
                WHEN voting_power BETWEEN 10000000000 AND 25000000000 THEN '10K-25k-8'
                WHEN voting_power BETWEEN 25000000000 AND 50000000000 THEN '25k-50k-9'
                WHEN voting_power BETWEEN 50000000000 AND 75000000000 THEN '50k-75k-10'
                WHEN voting_power BETWEEN 75000000000 AND 100000000000 THEN '75k-100k-11'
                WHEN voting_power BETWEEN 100000000000 AND 250000000000 THEN '100k-250k-12'
                WHEN voting_power BETWEEN 250000000000 AND 500000000000 THEN '250k-500k-13'
                WHEN voting_power BETWEEN 500000000000 AND 750000000000 THEN '500k-750k-14'
                WHEN voting_power BETWEEN 750000000000 AND 1000000000000 THEN '750k-1M-15'
                WHEN voting_power BETWEEN 1000000000000 AND 2000000000000 THEN '1M-2M-16'
                WHEN voting_power BETWEEN 2000000000000 AND 3000000000000 THEN '2M-3M-17'
                WHEN voting_power BETWEEN 3000000000000 AND 4000000000000 THEN '3M-4M-18'
                WHEN voting_power BETWEEN 4000000000000 AND 5000000000000 THEN '4M-5M-19'
                WHEN voting_power BETWEEN 5000000000000 AND 6000000000000 THEN '5M-6M-20'
                WHEN voting_power BETWEEN 6000000000000 AND 7000000000000 THEN '6M-7M-21'
                WHEN voting_power BETWEEN 7000000000000 AND 8000000000000 THEN '7M-8M-22'
                WHEN voting_power BETWEEN 8000000000000 AND 9000000000000 THEN '8M-9M-23'
                WHEN voting_power BETWEEN 9000000000000 AND 10000000000000 THEN '9M-10M-24'
                WHEN voting_power BETWEEN 10000000000000 AND 11000000000000 THEN '10M-11M-25'
                WHEN voting_power BETWEEN 11000000000000 AND 12000000000000 THEN '11M-12M-26'
                WHEN voting_power > 1200000000000 THEN '> 15M'
                WHEN voting_power > 2000000000000 THEN '> 20M'
                END as range,  COUNT(*) as wallets, SUM(voting_power) as ada"
            )->whereIn('catalyst_snapshot_id', [5])
            ->groupByRaw(1);

        $adaPowerRangesCollection = $agg->get()
        ->map(fn ($row) => [$row->range => [$row->wallets, $row->ada]])
        ->collapse();

        // convert the collection to an associative array whose structure is fully representative of our front-end needs
        $adaPowerRangesFormattedArray = [];
        foreach ($adaPowerRangesCollection as $range => $value) {
            $rangeArray = explode('-', $range);
            $finalRange = $rangeArray[0].' - '.$rangeArray[1];

            $adaPowerRangesFormattedArray[$finalRange] = [$value['0'], round($value['1'] / 1000000, 2), $rangeArray['2']];
        }

        // convert then order the array to collection and assing to the objects $adaPowerRanges property
        $this->adaPowerRanges = collect($adaPowerRangesFormattedArray)->sortBy(function ($value, $key) {
            return $value['2'];
        });
    }
}
