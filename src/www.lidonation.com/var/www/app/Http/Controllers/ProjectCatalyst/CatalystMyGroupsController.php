<?php

namespace App\Http\Controllers\ProjectCatalyst;

use App\Http\Controllers\Controller;
use App\Models\CatalystGroup;
use App\Models\CatalystUser;
use App\Models\Proposal;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Inertia\Inertia;
use Inertia\Response;

class CatalystMyGroupsController extends Controller
{
    protected int $perPage = 24;

    public function manage(CatalystGroup $group)
    {
        return Inertia::render('Auth/UserGroupCard')
            ->with([
                'group' => $group,
            ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        return Inertia::render('Auth/UserGroups', $this->data());
    }

    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function proposals(Request $request = null, CatalystGroup $catalystGroup)
    {
        $per_page = request('per_page', 12);

        Proposal::withoutGlobalScopes();
        $proposals = Proposal::whereRelation('groups', 'id', $catalystGroup?->id)
            ->with(['fund', 'users'])
            ->orderBy('title');

        return $proposals->paginate($per_page)->onEachSide(0);
    }

    public function removeProposal(CatalystGroup $catalystGroup, $proposalID)
    {
        $catalystGroup->proposals()->detach($proposalID);

        return $this->proposals(null, $catalystGroup);
    }

    public function addProposal(CatalystGroup $catalystGroup, Request $request)
    {
        $proposals_id = $request->input('proposals_id');
        foreach ($proposals_id as $id) {
            $catalystGroup->proposals()->attach($id);
        }

        return $this->proposals(null, $catalystGroup);
    }

    public function getMembers(Request $request, CatalystGroup $catalystGroup)
    {
        $members = CatalystUser::whereRelation('groups', 'id', $catalystGroup?->id)
        ->paginate(8, ['*'], 'p')->setPath('/');

        return $members->through(fn ($user) => [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'profile_photo' => $user->profile_photo_url,
            'role' => $catalystGroup->owner->id === $user->id ? 'admin' : $user->role,
            'discord' => $user->discord,
        ]);
    }

    public function removeMembers(Request $request, CatalystGroup $catalystGroup, $catalystUserID)
    {
        $catalystGroup->members()->detach($catalystUserID);

        return $this->getMembers($request, $catalystGroup);
    }

    public function addMembers(Request $request, CatalystGroup $catalystGroup)
    {
        $newMembersIDs = $request->input('profileIDs');
        foreach ($newMembersIDs as $id) {
            $catalystGroup->members()->attach($id);
        }

        return $this->getMembers($request, $catalystGroup);
    }

    protected function data()
    {
        $user = auth()->user();
        $user?->load('catalyst_users');

        $catalystProfiles = $user->catalyst_profiles?->pluck('id');

        $query = CatalystGroup::with('owner')
            ->whereRelation('owner', fn ($query) => $query->whereIn('id', $catalystProfiles));
        $paginator = $query->paginate($this->perPage, ['*'], 'p')->setPath('/');

        $profilesQuery = CatalystUser::with('claimed_by_user')
            ->whereRelation('claimed_by_user', 'id', $user->id);

        $groupNames = $query->orderBy('created_at', 'desc')->pluck('name')->toArray();

        return [
            'groups' => $paginator->onEachSide(1)->toArray(),
            'profiles' => $profilesQuery->get(),
            'groupOptions' => $groupNames,
            'crumbs' => [
                ['label' => 'My Groups'],
            ],
        ];
    }
}
