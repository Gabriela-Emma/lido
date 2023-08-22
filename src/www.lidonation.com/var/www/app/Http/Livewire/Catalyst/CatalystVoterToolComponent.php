<?php

namespace App\Http\Livewire\Catalyst;

use App\Models\CatalystUser;
use App\Models\Proposal;
use App\Models\Snippet;
use App\Repositories\FundRepository;
use App\View\Components\PublicLayout;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Laravel\Scout\Builder;
use Livewire\Component;
use Livewire\WithPagination;
use MeiliSearch\Endpoints\Indexes;

/**
 * to index run php artisan ln:index ln__proposals 'funded,over_budget,challenge,fund'
 */
class CatalystVoterToolComponent extends Component
{
    use WithPagination;

    public Collection|array $challenges;

    public Collection|array|null|\Illuminate\Support\Collection $proposals;

    protected Builder $searchBuilder;

    protected LengthAwarePaginator $paginator;

    protected LengthAwarePaginator $groupSearchPaginator;

    public $fund;

    public string $model = CatalystUser::class;

    public int $perPage = 9;

    public ?string $orderBy = null;

    public ?string $order = null;

    public array $snippets = [];

    public array $searchArgs = [];

    public ?string $search = null;

    public ?string $searchGroup = null;

    public $locale = null;

    public function getPaginator(): LengthAwarePaginator
    {
        return $this->paginator;
    }

    public function getSearchGroupPaginator(): LengthAwarePaginator
    {
        return $this->groupSearchPaginator;
    }

    public function mount()
    {
        if (request()->has('group')) {
            $this->searchGroup = request()->query('group');
        }
        $this->locale = app()->getLocale();
        $this->snippets = Snippet::where('context', 'treasury-dashboard')
            ->orderBy('order')
            ->get()
            ->all();
        $this->fund = app(FundRepository::class)->funds('inGovernance')->first();
        $this->challenges = app(FundRepository::class)->fundChallenges($this->fund);
    }

    public function render(): Factory|View|Application
    {
        app()->setLocale($this->locale);
        if ($this->search || $this->searchGroup) {
            $this->query();
        }

        return view('livewire.catalyst.voter.voter-tool', (new PublicLayout())->data())
            ->layoutData([
                'metaTitle' => 'Catalyst Voter Tool',
            ]);
    }

    protected function query()
    {
        $this->searchArgs['term'] = $this->search;
        if ($this->searchGroup == 'oneTimers' || $this->searchGroup == 'firstTimers') {
            $user_options = [
                'filters' => [],
            ];
            if ($this->searchGroup == 'firstTimers') {
                $user_options['filters'] = "first_timer = true AND proposals.fund = {$this->fund?->id}";
            }

            if ($this->searchGroup == 'oneTimers') {
                $user_options['filters'][] = "proposals_count = 1 AND proposals.fund = {$this->fund?->id}";
            }

            $this->searchBuilder = CatalystUser::search(null,
                function (Indexes $index, $query, $options) use ($user_options) {
                    $options['filter'] = $user_options['filters'];
                    $options['attributesToRetrieve'] = ['id', 'proposals.id'];

                    return $index->search($query, $options);
                });
            $this->searchArgs['filters'] = $user_options['filters'];
            $this->setQueryResults();

            return;
        }

        $_options = [
            'filters' => ["fund.id = {$this->fund?->id}"],
        ];

        if ($this->searchGroup == 'allStars') {
            $_options['filters'][] = 'ca_rating = 5';
        }

        if ($this->searchGroup == 'smallProposals') {
            $_options['filters'][] = 'amount_requested <= 10000';
        }

        if ($this->searchGroup == '100KProposals') {
            $_options['filters'][] = 'amount_requested >= 100000';
        }

        if ($this->searchGroup == 'largeProposals') {
            $_options['filters'][] = 'amount_requested > 25000';
        }

        if ($this->searchGroup == 'impactProposals') {
            $_options['filters'][] = 'impact_proposal = true';
        }

        if ($this->searchGroup == 'quickPitchProposals') {
            $_options['filters'][] = 'has_quick_pitch = 1';
        }

        if ($this->searchGroup == 'ideafestProposals') {
            $_options['filters'][] = 'ideafest_proposal = true';
        }

        $this->searchArgs['filters'] = $_options['filters'];

        $this->searchBuilder = Proposal::search($this->search,
            function (Indexes $index, $query, $options) use ($_options) {
                $options['filter'] = implode(' AND ', $_options['filters']);
                $options['attributesToRetrieve'] = ['id'];

                return $index->search($query, $options);
            });

        $this->setQueryResults();
    }

    protected function setQueryResults()
    {
        if ($this->searchGroup == 'oneTimers' || $this->searchGroup == 'firstTimers') {
            $this->groupSearchPaginator = $this->searchBuilder->paginate(18);
            $this->proposals = collect($this->groupSearchPaginator->items())->map(fn ($u) => $u->proposals)->collapse()->unique('id');
            $this->searchArgs['count'] = $this->groupSearchPaginator->total();

            return;
        }

        if ($this->searchGroup == 'allStars'
            || $this->searchGroup == 'impactProposals'
            || $this->searchGroup == 'ideafestProposals'
            || $this->searchGroup == 'smallProposals'
            || $this->searchGroup == '100KProposals'
            || $this->searchGroup == 'largeProposals') {
            $this->groupSearchPaginator = $this->searchBuilder->paginate(18);
            $this->searchArgs['count'] = $this->groupSearchPaginator->total();
            $this->proposals = $this->groupSearchPaginator->items();
        } elseif ($this->searchGroup == 'quickPitchProposals') {
            if (! $this->orderBy) {
                $this->orderBy = (string) collect(["UPPER(title->>'en')", 'amount_requested'])->random();
                $this->order = (string) collect(['DESC', 'ASC'])->random();
            }
            $orderClause = "{$this->orderBy} {$this->order}";
            $this->groupSearchPaginator = Proposal::whereRelation('metas', 'key', '=', 'quick_pitch')
                ->whereRelation('fund.parent', 'id', '=', 97)
                ->orderbyRaw($orderClause)->paginate(18);
            $this->searchArgs['count'] = $this->groupSearchPaginator->total();
            $this->proposals = $this->groupSearchPaginator->items();
        } elseif ($this->searchGroup == 'completedProposers') {
            if (! $this->orderBy) {
                $this->orderBy = (string) collect(["UPPER(title->>'en')", 'amount_requested'])->random();
                $this->order = (string) collect(['DESC', 'ASC'])->random();
            }
            $orderClause = "{$this->orderBy} {$this->order}";

            $this->groupSearchPaginator = Proposal::whereHas(
                'users',
                fn ($q) => $q->whereRelation('proposals', 'proposals.status', '=', 'complete')
            )->whereRelation('fund.parent', 'id', '=', 97)
                ->orderbyRaw($orderClause)
                ->paginate(18);
            $this->searchArgs['count'] = $this->groupSearchPaginator->total();
            $this->proposals = $this->groupSearchPaginator->items();
        } elseif ($this->searchGroup == 'womanProposals') {
            if (! $this->orderBy) {
                $this->orderBy = (string) collect(["UPPER(title->>'en')", 'amount_requested'])->random();
                $this->order = (string) collect(['DESC', 'ASC'])->random();
            }
            $orderClause = "{$this->orderBy} {$this->order}";
            $this->groupSearchPaginator = Proposal::whereRelation('metas', 'key', '=', 'woman_proposal')
                ->orderbyRaw($orderClause)->paginate(18);
            $this->searchArgs['count'] = $this->groupSearchPaginator->total();
            $this->proposals = $this->groupSearchPaginator->items();
        } else {
            $this->paginator = $this->searchBuilder->paginate($this->perPage);
            $this->searchArgs['count'] = $this->paginator->total();
            $this->proposals = $this->paginator->items();
        }
    }
}
