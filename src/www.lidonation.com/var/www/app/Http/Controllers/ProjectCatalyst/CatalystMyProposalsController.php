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

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        $user->load('catalyst_users');

        $catalystProfiles = $user->catalyst_users?->pluck('id');

        $query = Proposal::whereIn('user_id', $catalystProfiles);
        $paginator = $query->paginate($this->perPage, ['*'], 'p')->setPath('/');

        return Inertia::render('auth/UserProposals', [
            'proposals' => $paginator->onEachSide(1)->toArray(),
            'crumbs' => [
                ['label' => 'Profile'],
            ],
        ]);
    }
}
