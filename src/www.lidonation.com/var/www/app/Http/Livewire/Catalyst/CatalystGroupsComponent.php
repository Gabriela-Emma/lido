<?php

namespace App\Http\Livewire\Catalyst;

use App\Models\CatalystGroup;
use App\Models\CatalystUser;
use App\Models\Snippet;
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
class CatalystGroupsComponent extends Component
{
    use WithPagination;

    public Collection|array $catalystGroups;

    public array $activeSelectFilters = [];

    public int $perPage = 24;

    public array $snippets = [];

    public string $sortOrder = 'desc';

    public string $sortBy = 'amount_awarded';

    public ?string $search = null;

    public $locale = null;

    public string $metaTitle = 'Catalyst Groups';

    // metrics
    public int $catalystGroupsCount;

    protected Builder $searchBuilder;

    protected LengthAwarePaginator $paginator;

    public function query()
    {
        if (! $this->search) {
            $query = CatalystGroup::where('status', 'published')
                ->whereHas('proposals', fn ($q) => $q->whereNotNull('funded_at'))
                ->withSum([
                    'proposals as amount_awarded' => function ($query) {
                        $query->whereNotNull('funded_at');
                    }, ],
                    'amount_requested');
            if ($this->sortBy !== 'none' && $this->sortOrder !== 'none') {
                $query->orderBy($this->sortBy, $this->sortOrder);
            }
            $this->paginator = $query->fastPaginate($this->perPage);
            $this->catalystGroups = $this->paginator->items();
            $this->catalystGroupsCount = $this->paginator->total();

            return;
        }

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
        $this->catalystGroups = $this->paginator->items();

        /////
        //////// get stats
        /////
        $this->catalystGroupsCount = $this->paginator?->total();
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

    public function getPaginator(): LengthAwarePaginator
    {
        return $this->paginator;
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

        return view('livewire.catalyst.proposer.groups')->layoutData([
            'metaTitle' => $this->metaTitle,
        ]);
    }
}
