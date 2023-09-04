<?php

namespace App\Http\Livewire\Catalyst;

use App\Models\CatalystUser;
use App\Models\Snippet;
use App\View\Components\PublicLayout;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use JetBrains\PhpStorm\ArrayShape;
use Laravel\Scout\Builder;
use Livewire\Component;
use Livewire\WithPagination;
use MeiliSearch\Endpoints\Indexes;

/**
 * to index run php artisan ln:index ln__proposals 'funded,over_budget,challenge,fund'
 */
class CatalystProposersComponent extends Component
{
    use WithPagination;

    public Collection|array $catalystUsers;

    public string $model = CatalystUser::class;

    public array $activeSelectFilters = [];

    public int $perPage = 24;

    public array $snippets = [];

    public string $sortOrder = 'desc';

    public string $sortBy = 'yes_votes_count';

    public ?string $search = null;

    public $locale = null;

    // metrics
    public int $catalystUsersCount;

    protected Builder $searchBuilder;

    protected LengthAwarePaginator $paginator;

    public function query()
    {
        $_options = [
            'filters' => array_merge([], $this->getUserFilters()),
        ];

        $this->searchBuilder = CatalystUser::search($this->search,
            function (Indexes $index, $query, $options) use ($_options) {
                if (count($_options['filters']) > 0) {
                    $options['filter'] = implode(' AND ', $_options['filters']);
                }
                $options['attributesToRetrieve'] = ['id'];
                if (! $this->search) {
                    $options['sort'] = ['name:asc'];
                }
                $options['limit'] = $this->perPage;

                return $index->search($query, $options);
            });
        $this->paginator = $this->searchBuilder->fastPaginate($this->perPage);
        $this->catalystUsers = $this->paginator->items();

        /////
        //////// get stats
        /////
        $this->catalystUsersCount = $this->paginator?->total();

        // push analytics
        $this->dispatchBrowserEvent('analytics-event-fired', ['code' => '9LFJXIOD']);
    }

    public function getPaginator(): LengthAwarePaginator
    {
        return $this->paginator;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function mount()
    {
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

        return view('livewire.catalyst.proposer.proposers', (new PublicLayout())->data())
            ->layoutData([
                'metaTitle' => 'Catalyst Proposers',
            ]);
    }

    #[ArrayShape(['filters' => 'array'])]
    protected function getUserFilters(): array
    {
        $_options = [];

        return $_options;
    }
}
