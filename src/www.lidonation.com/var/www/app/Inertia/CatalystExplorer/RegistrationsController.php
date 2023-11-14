<?php

namespace App\Inertia\CatalystExplorer;

use App\Http\Controllers\Controller;
use App\Jobs\GetVoterHistory;
use App\Models\CatalystExplorer\CatalystRegistration;
use App\Models\CatalystExplorer\CatalystVoter;
use App\Models\CatalystExplorer\Fund;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Inertia\Inertia;
use Inertia\Response;
use JetBrains\PhpStorm\ArrayShape;
use JsonMachine\Items;

class RegistrationsController extends Controller
{
    public int $perPage = 24;

    public ?string $search = null;

    public ?int $currentPage;

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

        // props
        $props = [
            'searchTerm' => $this->search,
            'perPage' => $this->perPage,
            'crumbs' => [
                ['label' => 'Registrations'],
            ],
        ];
        if ($this->currentPage > 1) {
            $props['currPage'] = $this->currentPage;
        }

        return Inertia::render('Registrations', $props);
    }

    public function registrationsData(Request $request)
    {
        $this->search = $request->input('s', null);
        $this->perPage = $request->input('l', 24);
        $this->currentPage = $request->input('p', 1);
        $registrationBuilder = CatalystRegistration::where('stake_pub', $this->search);
        $paginatedResults = $registrationBuilder->fastPaginate($this->perPage, ['*'], 'p', $this->currentPage)
            ->setPath('/')->onEachSide(1);

        return $paginatedResults->toArray();
    }

    #[ArrayShape(['filters' => 'array'])]
    protected function getUserFilters(): array
    {
        $_options = [];

        return $_options;
    }

    public function getVoterData(Request $request): array
    {
        $search = $request->input('s', null);
        $perPage = $request->input('l', 24);
        $currentPage = $request->input('p', 1);
        $filePath = '/data/catalyst-tools/voting-history/f10/'.$search.'.json';

        if (! file_exists($filePath)) {
            $voter = CatalystVoter::with('voting_powers')
                ->where('stake_pub', $search)->whereHas('voting_powers', function ($q) {
                    $q->whereHas('snapshot', function ($q) {
                        $q->where('model_type', Fund::class)->where('model_id', 113);
                    });
                })->first();

            if ($voter instanceof CatalystVoter) {
                GetVoterHistory::dispatchSync($voter->voting_powers?->first());
                sleep(5);
            }
        }

        if (file_exists($filePath)) {
            $jsonContents = Items::fromFile($filePath);
            $collection = new Collection($jsonContents);

            $paginatedData = $collection->slice(($currentPage - 1) * $perPage, $perPage)->values();

            $paginator = new LengthAwarePaginator(
                $paginatedData,
                $collection->count(),
                $perPage,
                $currentPage,
                [
                    'pageName' => 'p',
                ]
            );

            return $paginator->onEachSide(1)->toArray();
        }

        return [];
    }
}
