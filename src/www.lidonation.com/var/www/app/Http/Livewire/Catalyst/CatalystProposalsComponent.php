<?php

namespace App\Http\Livewire\Catalyst;

use App\Models\Proposal;
use App\Models\Snippet;
use App\Repositories\FundRepository;
use App\Repositories\ProposalRepository;
use App\View\Components\PublicLayout;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use JetBrains\PhpStorm\ArrayShape;
use Laravel\Scout\Builder;
use Livewire\Component;
use Livewire\WithPagination;
use MeiliSearch\Endpoints\Indexes;

/**
 * to index run php artisan ln:index ln__proposals 'funded,over_budget,challenge,fund'
 */
class CatalystProposalsComponent extends Component
{
    use WithPagination;

    public Collection $funds;

    public Collection $challenges;

    public Collection|array $proposals;

    public string $model = Proposal::class;

    public array $activeSelectFilters = [];

    public int $perPage = 16;

    public ?int $totalProposals;

    public ?string $totalAwardedAmount;

    public array $snippets = [];

    public ?string $sortOrder = 'desc';

    public ?string $sortBy = 'amount_requested';

    public ?string $search = null;

    // filters
    public ?array $fundFilter = [];

    public ?string $proposalTypeFilter = 'all';

    public array $challengeFilter = [];

    public int $fundedProposalsFilter = 0;

    public int $completedProposalsFilter = 0;

    public int $impactProposalsFilter = 0;

    public int $overBudgetProposalsFilter = 0;

    public $locale = null;

    // metrics
    public int $fundedProposalsCount;

    public int $completedProposalsCount;

    public int $fundedChallengesCount;

    public int $approvedChallengesCount;

    public int $challengesCount;

    protected Builder $searchBuilder;

    protected LengthAwarePaginator $paginator;

    public function query()
    {
        $_options = [
            'filters' => array_merge([
                //                'type = proposal'
            ], $this->getUserFilters()),
        ];

        // filter by funded bool
        if ($this->fundedProposalsFilter) {
            $_options['filters'][] = 'funded = 1';
        }
        if ($this->completedProposalsFilter) {
            $_options['filters'][] = 'completed = 1';
        }
        if ($this->impactProposalsFilter) {
            $_options['filters'][] = 'impact_proposal = true';
        }
        if ($this->proposalTypeFilter !== 'all') {
            $_options['filters'][] = "type = $this->proposalTypeFilter";
        }

        $this->searchBuilder = Proposal::search($this->search,
            function (Indexes $index, $query, $options) use ($_options) {
                if (count($_options['filters']) > 0) {
                    $options['filter'] = implode(' AND ', $_options['filters']);
                }
                $options['attributesToRetrieve'] = ['id'];
                if ($this->sortBy !== 'none' && $this->sortOrder !== 'none') {
                    $options['sort'] = ["$this->sortBy:$this->sortOrder"];
                } else {
                    if (! $this->search) {
                        $options['sort'] = ['created_at:desc'];
                    }
                }

                return $index->search($query, $options);
            });

        $this->paginator = $this->searchBuilder->paginate(
            $this->perPage,
            // @todo, skip converting to eloquent models and paginate directly out of search engine with only columns needed for the drip
//            [
//                'id',
//                'title',
//                'funded_at',
//                'funding_status',
//                'ideascale_link',
//                'website',
//                'funding_updated_at',
//                'amount_requested',
//                'amount_received'
//            ]
        );
        $this->proposals = $this->paginator->items();

        /////
        //////// get stats
        /////
        $this->setTotalProposalsCountMetric();
        $this->setAwardedAmount();
        $this->setFundedProposalsCountMetric();
        $this->setCompletedProposalsCountMetric();
        $this->setChallengeMetrics();

        $this->dispatchBrowserEvent('analytics-event-fired', ['code' => 'RPZTGJL8']);
        // over budget proposals
    }

    public function getPaginator(): LengthAwarePaginator
    {
        return $this->paginator;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function sortBy($attribute)
    {
        if ($attribute !== $this->sortBy) {
            $this->sortOrder = 'desc';
            $this->sortBy = $attribute;

            return;
        }
        $this->sortBy = $attribute;
        $this->sortOrder = match ($this->sortOrder) {
            'desc' => 'asc',
            'asc' => 'none',
            'none' => 'desc',
        };
        if ($this->sortOrder === 'none') {
            $this->sortBy = 'none';
        }
    }

    public function mount(FundRepository $fundRepository, ProposalRepository $proposalRepository)
    {
        $this->challenges = $fundRepository->funds('challenges');
        $this->funds = $fundRepository->funds('topLevel');
        $this->locale = app()->getLocale();
        $this->snippets = Snippet::where('context', 'treasury-dashboard')
            ->orderBy('order')
            ->get()
            ->all();
    }

    public function render(): Factory|View|Application
    {
        app()->setLocale($this->locale);
        $this->query();

        return view('livewire.catalyst.proposal.proposals', (new PublicLayout('Project Catalyst'))->data())
            ->layoutData([
                'metaTitle' => 'Catalyst Proposals',
            ]);
    }

    #[ArrayShape(['filters' => 'array'])]
    protected function getUserFilters(): array
    {
        $_options = [];

        // filter by fund
        if ((bool) $this->fundFilter) {
            $_filters = [];
            foreach ($this->fundFilter as $fund) {
                $_filters[] = "fund = {$fund}";
            }
            if (count($_filters) > 0) {
                $_options[] = implode(' OR ', $_filters);
            }
        }

        // filter by challenge
//        if ((bool) $this->challengeFilter) {
//            $_options[] = "challenge = $this->challengeFilter";
//        }
        if ((bool) $this->challengeFilter) {
            $_filters = [];
            foreach ($this->challengeFilter as $challenge) {
                $_filters[] = "challenge = {$challenge}";
            }
            if (count($_filters) > 0) {
                $_options[] = implode(' OR ', $_filters);
            }
        }

        // filter by over budget bool
        if ((bool) $this->overBudgetProposalsFilter) {
            $_options[] = 'over_budget = 1';
        }

        return $_options;
    }

    protected function setFundedProposalsCountMetric()
    {
        $_options = [
            'filters' => array_merge(['funded = 1 AND type = proposal'], $this->getUserFilters()),
        ];

        $searchBuilder = Proposal::search($this->search,
            function (Indexes $index, $query, $options) use ($_options) {
                if (count($_options['filters']) > 0) {
                    $options['filter'] = implode(' AND ', $_options['filters']);
                }

                $options['hitsPerPage'] = 1;
                $options['page'] = 1;

                return $index->rawSearch($query, $options);
            });

        $this->fundedProposalsCount = $searchBuilder->raw()['totalHits'] ?? 0;
    }

    protected function setCompletedProposalsCountMetric()
    {
        $_options = [
            'filters' => array_merge(['completed = 1 AND type = proposal'], $this->getUserFilters()),
        ];

        $searchBuilder = Proposal::search($this->search,
            function (Indexes $index, $query, $options) use ($_options) {
                if (count($_options['filters']) > 0) {
                    $options['filter'] = implode(' AND ', $_options['filters']);
                }
                $options['hitsPerPage'] = 1;
                $options['page'] = 1;

                return $index->rawSearch($query, $options);
            });

        $this->completedProposalsCount = $searchBuilder->raw()['totalHits'] ?? 0;
    }

    protected function setTotalProposalsCountMetric()
    {
        $_options = [
            'filters' => array_merge(['type = proposal'], $this->getUserFilters()),
        ];

        $searchBuilder = Proposal::search($this->search,
            function (Indexes $index, $query, $options) use ($_options) {
                if (count($_options['filters']) > 0) {
                    $options['filter'] = implode(' AND ', $_options['filters']);
                }
                $options['hitsPerPage'] = 1;
                $options['page'] = 1;

                return $index->rawSearch($query, $options);
            });

        $this->totalProposals = $searchBuilder->raw()['totalHits'];
    }

    protected function setChallengeMetrics()
    {
        // all challenges
        $_options = [
            'filters' => array_merge(['type = challenge'], $this->getUserFilters()),
        ];
        $searchBuilder = Proposal::search($this->search,
            function (Indexes $index, $query, $options) use ($_options) {
                if (count($_options['filters']) > 0) {
                    $options['filter'] = implode(' AND ', $_options['filters']);
                }
                $options['hitsPerPage'] = 1;
                $options['page'] = 1;

                return $index->rawSearch($query, $options);
            });
        $this->challengesCount = $searchBuilder->raw()['totalHits'] ?? 0;

        // approved challenges
        $_options = [
            'filters' => array_merge(['funded = 1 AND  type = challenge'], $this->getUserFilters()),
        ];
        $searchBuilder = Proposal::search($this->search,
            function (Indexes $index, $query, $options) use ($_options) {
                if (count($_options['filters']) > 0) {
                    $options['filter'] = implode(' AND ', $_options['filters']);
                }
                $options['hitsPerPage'] = 1;
                $options['page'] = 1;

                return $index->rawSearch($query, $options);
            });
        $this->approvedChallengesCount = $searchBuilder->raw()['totalHits'] ?? null;
    }

    protected function setFundedChallengesCountMetric()
    {
        $_options = [
            'filters' => array_merge(['funded = 1 AND type = challenge'], $this->getUserFilters()),
        ];

        $searchBuilder = Proposal::search($this->search,
            function (Indexes $index, $query, $options) use ($_options) {
                if (count($_options['filters']) > 0) {
                    $options['filter'] = implode(' AND ', $_options['filters']);
                }
                $options['hitsPerPage'] = 1;
                $options['page'] = 1;

                return $index->rawSearch($query, $options);
            });

        $this->fundedChallengesCount = $searchBuilder->raw()['totalHits'] ?? null;
    }

    protected function setAwardedAmount()
    {
        $filters = $this->getUserFilters();
        if (count($filters) <= 0 && ! $this->search) {
            $this->totalAwardedAmount = DB::table('proposals')
                ->where('type', 'proposal')
                ->whereNotNull('funded_at')
                ->sum('amount_requested');

            return null;
        }

        $_options = [
            'filters' => array_merge(
                ['funded = 1 AND type = proposal'],
                $this->getUserFilters()
            ),
        ];

        $searchBuilder = Proposal::search($this->search,
            function (Indexes $index, $query, $options) use ($_options) {
                if (count($_options['filters']) > 0) {
                    $options['filter'] = implode(' AND ', $_options['filters']);
                }
                $options['attributesToRetrieve'] = ['amount_requested'];
                $options['limit'] = 10000;

                return $index->search($query, $options);
            });

        $this->totalAwardedAmount = collect($searchBuilder->raw()['hits'])->sum('amount_requested');
    }
}
