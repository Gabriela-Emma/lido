<?php

namespace App\Http\Livewire\Catalyst;

use App\Models\CatalystReport;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;
use Livewire\WithPagination;

class CatalystReportsComponent extends Component
{
    use WithPagination;

    public Collection|array $catalystReports;

    public int $perPage = 45;

    public array $snippets = [];

    public string $sortOrder = 'desc';

    public string $sortBy = 'yes_votes_count';

    public ?string $search = null;

    public $locale = null;

    public string $metaTitle = 'Catalyst Monthly Reports';

    public int $fundedProposalsCount;

    protected LengthAwarePaginator $paginator;

    public function query()
    {
        $query = CatalystReport::withOnly(['proposal.author']);
        if (isset($this->search)) {
            $query->orWhereFullText('content', $this->search)
                ->orWhereHas('proposal', fn ($q) => $q->where('title', 'iLIKE', "%{$this->search}%"))
                ->orWhereHas('proposal.author', fn ($q) => $q->where('username', 'iLIKE', "%{$this->search}%")
                    ->orWhere('name', 'iLIKE', "%{$this->search}%"));
            $this->perPage = 18;
            $this->dispatchBrowserEvent('analytics-event-fired', ['code' => 'HSH9YZDM']);
        }
        $this->paginator = $query->fastPaginate($this->perPage);

        $this->catalystReports = $this->paginator->items();
    }

    public function getPaginator(): LengthAwarePaginator
    {
        return $this->paginator;
    }

    public function mount()
    {
        $this->locale = app()->getLocale();
    }

    public function render(): Factory|View|Application
    {
        app()->setLocale($this->locale);
        $this->query();

        return view('livewire.catalyst.proposal.reports')->layoutData([
            'metaTitle' => $this->metaTitle,
        ]);
    }
}
