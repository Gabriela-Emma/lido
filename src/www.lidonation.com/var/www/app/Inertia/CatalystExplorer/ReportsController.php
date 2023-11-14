<?php

namespace App\Inertia\CatalystExplorer;

use App\Http\Controllers\Controller;
use App\Models\CatalystExplorer\CatalystReport;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ReportsController extends Controller
{
    public int $perPage = 24;

    public ?string $search = null;

    protected int $currentPage = 1;

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $this->search = $request->input('s', null);

        $this->perPage = $request->input('l', 24);

        $this->currentPage = $request->input('p', 1);

        return Inertia::render('Reports', [
            'search' => $this->search,
            'reports' => $this->query($request),
            'currPage' => $this->currentPage,
            'perPage' => $this->perPage,
            'crumbs' => [
                ['label' => 'Reports'],
            ],
        ]);
    }

    protected function query(Request $request)
    {
        $query = CatalystReport::withOnly(['proposal.author'])
            ->withCount([
                'hearts',
                'eyes',
                'party_popper',
                'rocket',
                'thumbs_down',
                'thumbs_up',
            ]);
        if (isset($this->search)) {
            $query->orWhereFullText('content', $this->search)
                ->orWhereHas('proposal', fn ($q) => $q->where('title', 'iLIKE', "%{$this->search}%"))
                ->orWhereHas('proposal.author', fn ($q) => $q->where('username', 'iLIKE', "%{$this->search}%")
                    ->orWhere('name', 'iLIKE', "%{$this->search}%"));
            //            $this->dispatch('analytics-event-fired', ['code' => 'HSH9YZDM']);
        }
        $paginator = $query->fastPaginate($this->perPage, $this->currentPage, 'p');

        return $paginator->toArray();
    }
}
