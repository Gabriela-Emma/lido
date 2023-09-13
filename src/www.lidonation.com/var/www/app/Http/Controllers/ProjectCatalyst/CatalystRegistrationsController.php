<?php

namespace App\Http\Controllers\ProjectCatalyst;

use App\Http\Controllers\Controller;
use App\Models\CatalystRegistration;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use JetBrains\PhpStorm\ArrayShape;

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
}
