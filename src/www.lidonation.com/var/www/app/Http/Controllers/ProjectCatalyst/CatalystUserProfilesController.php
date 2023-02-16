<?php

namespace App\Http\Controllers\ProjectCatalyst;

use App\Http\Controllers\Controller;
use App\Models\CatalystUser;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class CatalystUserProfilesController extends Controller
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
        $query = CatalystUser::with('claimed_by_user')
            ->whereRelation('claimed_by_user', 'id', $user->id);

        $paginator = $query->paginate($this->perPage, ['*'], 'p')->setPath('/');

        return Inertia::render('auth/UserProfiles', [
            'profiles' => $paginator->onEachSide(1)->toArray(),
            'crumbs' => [
                ['label' => 'Profiles'],
            ],
        ]);
    }

    public function update(Request $request, CatalystUser $catalystUser)
    {
        $request->validate([
            'email' => 'sometimes|email',
            'twitter' => 'nullable|bail|min:2',
            'linkedin' => 'nullable|bail|min:2',
            'discord' => 'nullable|bail|min:2',
            'telegram' => 'nullable|bail|min:2',
            'bio' => 'min:10'
        ]);

        $catalystUser->bio =  $request->bio;
        $catalystUser->twitter = $request->twitter;
        $catalystUser->linkedin = $request->linkedin;
        $catalystUser->discord = $request->discord;
        $catalystUser->save();

        return to_route('catalystExplorer.myProfiles');
    }
}
