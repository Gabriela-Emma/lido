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

    protected ?bool $fundedProposalsFilter = true;

    public function manage(Proposal $proposal)
    {
        return Inertia::modal('auth/UserProposal')
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

        return Inertia::render('auth/UserProposals', $this->data());
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

        $totalDistributed = floatval($query->when($this->fundedProposalsFilter, function ($query) {
            return $query->whereNotNull('funded_at');
        })->sum('amount_received'));

        $budgetSummary = floatval($query->when($this->fundedProposalsFilter, function ($query) {
            return $query->whereNotNull('funded_at');
        })->sum('amount_requested'));

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
