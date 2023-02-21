<?php

namespace App\Http\Controllers\ProjectCatalyst;

use App\Http\Controllers\Controller;
use App\Models\CatalystGroup;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class CatalystMyGroupsController extends Controller
{
    protected int $perPage = 24;

    public function manage(CatalystGroup $group)
    {
        return Inertia::modal('auth/UserGroupCard')
            ->with([
                'group' => $group,
            ])
            ->baseRoute('catalystExplorer.myGroups');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        return Inertia::render('auth/UserGroups', $this->data());
    }

    protected function data()
    {
        $user = auth()->user();
        $user?->load('catalyst_users');

        $catalystProfiles = $user->catalyst_profiles?->pluck('id');

        $query = CatalystGroup::with('owner')
            ->whereRelation('owner', fn ($query) => $query->whereIn('id', $catalystProfiles));
        $paginator = $query->paginate($this->perPage, ['*'], 'p')->setPath('/');

        return [
            'groups' => $paginator->onEachSide(1)->toArray(),
            'crumbs' => [
                ['label' => 'My Groups'],
            ],
        ];
    }
}
