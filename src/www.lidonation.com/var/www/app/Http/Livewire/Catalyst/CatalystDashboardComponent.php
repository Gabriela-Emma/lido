<?php

namespace App\Http\Livewire\Catalyst;

use App\Models\CatalystGroup;
use App\Models\CatalystUser;
use App\Models\Fund;
use App\Models\Proposal;
use App\Models\Snippet;
use App\View\Components\PublicLayout;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

/**
 * to index run php artisan ln:index ln__proposals 'funded,over_budget,challenge,fund'
 */
class CatalystDashboardComponent extends Component
{
    public ?Collection $wordCloudSet;

    public ?Collection $fundedAverageSet;

    public array $snippets = [];

    public $locale = null;

    public $largestProposal;

    public ?int $fundedOver75K;

    public ?int $numberOfBuilders;

    public ?int $startups;

    public ?int $numberOfFundedBuilders;

    public ?int $completedProposals;

    public ?int $completedProposalsSum;

    public ?int $proposalsSum;

    public ?int $avgFundedProposals;

    public ?int $fullyDisbursed;

    public ?int $fundedProposalsSum;

    public $topFundedProposals;

    public function query()
    {
    }

    public function getPaginator(): LengthAwarePaginator
    {
        return $this->paginator;
    }

    public function mount()
    {
        $this->setTagCloud();
        $this->setFundedAverage();
        $this->setLargestAmounts();
        $this->locale = app()->getLocale();
        $this->snippets = Snippet::where('context', 'treasury-dashboard')
            ->orderBy('order')
            ->get()
            ->all();
    }

    public function render(): Factory|View|Application
    {
        app()->setLocale($this->locale);

        return view('livewire.catalyst.dashboard.dashboard', (new PublicLayout())->data())
            ->layoutData([
                'metaTitle' => 'Catalyst Reports',
            ]);
    }

    protected function setLargestAmounts()
    {
        $this->largestProposal = Proposal::withOnly(['metas', 'fund', 'discussions.ratings'])->where('proposals.type', 'proposal')
            ->whereNotNull('funded_at')
            ->orderByDesc('amount_requested')
            ->first();

        // @todo optimize this query to remove 100+ n+1 queries
        $this->topFundedProposals = Proposal::with(['discussions.ratings', 'groups'])
            ->where('proposals.type', 'proposal')
            ->whereNotNull('funded_at')
            ->orderByDesc('amount_requested')
            ->limit(15)
            ->get();
        //
        $this->fundedOver75K = Proposal::where('proposals.type', 'proposal')
            ->whereNotNull('funded_at')
            ->where('amount_requested', '>=', 75000)
            ->count();
        //
        $this->completedProposals = Proposal::where('proposals.type', 'proposal')
            ->where('status', 'complete')
            ->count();

        $this->fullyDisbursed = Proposal::where('proposals.type', 'proposal')
            ->whereNotNull('funded_at')
            ->whereColumn('amount_requested', '=', 'amount_received')
            ->count();

        $this->numberOfFundedBuilders = CatalystUser::whereHas('proposals', fn ($q) => $q->whereNotNull('funded_at'))
            ->count();

        $this->completedProposalsSum = Proposal::where('proposals.type', 'proposal')
            ->where('status', 'complete')
            ->sum('amount_received');

        $this->avgFundedProposals = Proposal::whereNotNull('funded_at')
            ->where('type', 'proposal')
            ->avg('amount_requested');

        $this->fundedProposalsSum = Proposal::whereNotNull('funded_at')
            ->where('type', 'proposal')
            ->sum('amount_requested');

        $this->proposalsSum = Proposal::where('proposals.type', 'proposal')
            ->count();

        $this->numberOfBuilders = CatalystUser::whereHas('proposals')
            ->count();

        $this->startups = CatalystGroup::whereHas('proposals')
            ->count();
    }

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
}
