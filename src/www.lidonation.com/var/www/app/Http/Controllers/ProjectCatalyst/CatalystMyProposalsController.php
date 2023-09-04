<?php

namespace App\Http\Controllers\ProjectCatalyst;

use App\Http\Controllers\Controller;
use App\Scopes\OrderByDateScope;
use App\Models\Proposal;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Collection;
use App\Enums\CatalystExplorerQueryParams;

class CatalystMyProposalsController extends Controller
{
    protected int $perPage = 24;

    protected int $currentPage;

    protected ?bool $fundedProposalsFilter;

    public Collection $fundsFilter;

    public function manage(Proposal $proposal)
    {
        return Inertia::modal('Auth/UserProposal')
            ->with([
                'proposal' => $proposal,
            ])
            ->baseRoute('catalystExplorer.myProposals');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $this->fundedProposalsFilter = $request->input('fp', false);
        $this->currentPage = $request->input('p', 1);
        $this->perPage = $request->input('l', 24);
        $this->fundsFilter = $request->collect(CatalystExplorerQueryParams::FUNDS)->map(fn ($n) => intval($n));

        return Inertia::render('Auth/UserProposals', $this->data());
    }

    protected function data()
    {
        $user = auth()->user();
        $user?->load('catalyst_users');
        $fundsFilterArray = $this->fundsFilter->toArray();

        $catalystProfiles = $user->catalyst_users?->pluck('id');


        $query = Proposal::select('proposals.*')
        ->join('funds', 'proposals.fund_id', '=', 'funds.id')
        ->whereIn('proposals.user_id', $catalystProfiles)
        ->whereHas('fund', function ($query) use ($fundsFilterArray) {
            if (!empty($fundsFilterArray)) {
                $query->whereIn('funds.parent_id', $fundsFilterArray);
            }
        })
        ->orderBy('funds.launched_at', 'DESC')
        ->orderBy('proposals.funded_at', 'DESC');

        $paginator = $query->fastPaginate($this->perPage, ['*'], 'p')->setPath('/');

        $query->whereNotNull('funded_at');
        $totalDistributed = intval($query->sum('amount_received'));
        $budgetSummary = intval($query->sum('amount_requested'));

        $totalRemaining = ($budgetSummary - $totalDistributed);

        return [
            'filters' => [
                'funded' => $this->fundedProposalsFilter,
                'funds' => $this->fundsFilter->toArray(),
            ],
            'proposals' => $paginator->onEachSide(1)->toArray(),
            'totalDistributed' => $totalDistributed,
            'budgetSummary' => $budgetSummary,
            'totalRemaining' => $totalRemaining,
            'crumbs' => [
                ['label' => 'Profile'],
            ],
        ];
    }
}
