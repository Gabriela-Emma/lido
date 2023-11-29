<?php

namespace App\Inertia\CatalystExplorer;

use App\DataTransferObjects\VoterHistoryData;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\Wallet;
use JsonMachine\Items;
use Illuminate\Http\Request;
use App\Jobs\GetVoterHistory;
use JetBrains\PhpStorm\ArrayShape;
use App\Http\Controllers\Controller;
use App\Models\CatalystExplorer\Fund;
use Illuminate\Database\Eloquent\Collection;
use App\Models\CatalystExplorer\CatalystVoter;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\CatalystExplorer\CatalystRegistration;
use App\Models\CatalystExplorer\VoterHistory;

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

    public function getVoterData(Request $request):array
    {
        $search = $request->input('s', null);
        $perPage = $request->input('l', 24);

        $collection = VoterHistoryData::collection(VoterHistory::where('stake_address', $search )->fastPaginate($perPage, ['*'], 'p')?->setPath('/')->onEachSide(0));

        return $collection->toArray();

    }
}
