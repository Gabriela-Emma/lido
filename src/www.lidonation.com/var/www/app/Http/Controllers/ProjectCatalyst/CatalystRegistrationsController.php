<?php

namespace App\Http\Controllers\ProjectCatalyst;

use App\Jobs\GetVoterHistory;
use App\Models\CatalystVoter;
use App\Models\Fund;
use Inertia\Inertia;
use Inertia\Response;
use JsonMachine\Items;
use Illuminate\Http\Request;
use JetBrains\PhpStorm\ArrayShape;
use App\Http\Controllers\Controller;
use App\Models\CatalystRegistration;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;


class CatalystRegistrationsController extends Controller
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
            'search' => $this->search,
            'perPage' => $this->perPage,
            'registrations' => $this->query($request),
            'crumbs' => [
                ['label' => 'Registrations'],
            ],
        ];
        if ($this->currentPage > 1) {
            $props['currPage'] = $this->currentPage;
        }

        return Inertia::render('Registrations', $props);
    }

    protected function query(Request $request)
    {

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

    public function getVoterData(Request $request)
    {
        $search = $request->input('s', null);
        $perPage = $request->input('l', 24);
        $currentPage = $request->input('p', 1);

        $filePath = '/data/catalyst-tools/voting-history/f10/' . $search . '.json';

        if (!file_exists($filePath)) {
            $voter = CatalystVoter::with('voting_powers')
                ->where('stake_pub', $search)->whereHas('voting_powers', function ($q) {
                    $q->whereHas('snapshot', function ($q) {
                        $q->where('model_type', Fund::class)->where('model_id', 113);
                    });
                })->first();
            if ($voter instanceof CatalystVoter) {
                GetVoterHistory::dispatchSync($voter->voting_powers?->first());
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

            return
                $paginator->onEachSide(1)->toArray();
        }

        return [];
    }
}
