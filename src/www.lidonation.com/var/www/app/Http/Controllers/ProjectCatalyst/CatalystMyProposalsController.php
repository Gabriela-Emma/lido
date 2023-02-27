<?php

namespace App\Http\Controllers\ProjectCatalyst;

use App\Http\Controllers\Controller;
use App\Models\Proposal;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class CatalystMyProposalsController extends Controller
{
    protected int $perPage = 24;
    protected int $currentPage;

    protected ?bool $fundedProposalsFilter = true;

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
        $this->fundedProposalsFilter = $request->input('fp', true);
        $this->currentPage = $request->input('p', 1);
        $this->perPage = $request->input('l', 24);

        return Inertia::render('Auth/UserProposals', $this->data());
    }

    protected function data()
    {
        $user = auth()->user();
        $user?->load('catalyst_users');

        $catalystProfiles = $user->catalyst_users?->pluck('id');

        $query = Proposal::whereIn('user_id', $catalystProfiles)
        ->when($this->fundedProposalsFilter, function ($query) {
            return $query->whereNotNull('funded_at');});

        $paginator = $query->paginate($this->perPage, ['*'], 'p')->setPath('/');

        // dd($paginator->getCollection());

        $totalDistributed = $paginator->sum('amount_received');
        $budgetSummary = $paginator->sum('amount_requested');
        $totalRemaining = ($budgetSummary - $totalDistributed);

        return [
            'filters' =>['funded' => $this->fundedProposalsFilter],
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
