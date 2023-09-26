<?php

namespace App\Http\Controllers\ProjectCatalyst;

use App\Http\Controllers\Controller;
use App\Models\CatalystGroup;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Fluent;
use Inertia\Inertia;
use Inertia\Response;

class CatalystGroupsController extends Controller
{
    public int $perPage = 24;

    public ?string $search = null;

    public ?string $sort = null;

    protected int $currentPage;

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $this->search = $request->input('s', null);
        $this->perPage = $request->input('l', 24);
        $this->sort = $request->input('st', null);
        $this->currentPage = $request->input('p', 1);

        $props = [
            'search' => $this->search,
            'perPage' => $this->perPage,
            'sort' => $this->sort,
            'groups' => $this->query(),
            'crumbs' => [
                ['label' => 'Groups'],
            ],
        ];
        if ($this->currentPage > 1) {
            $props['currPage'] = $this->currentPage;
        }

        return Inertia::render('Groups', $props);
    }

    public function create(Request $request)
    {
        $validated = new Fluent($request->validate([
            'email' => 'sometimes|email',
            'website' => 'sometimes',
            'twitter' => 'nullable|bail|min:2',
            'github' => 'nullable|bail|min:5',
            'discord' => 'nullable|bail|min:4',
            'telegram' => 'nullable|bail|min:2',
            'bio' => 'min:10',
            'name' => 'required|min:10',
            'owner.id' => 'required:exists:catalyst_groups',
        ]));

        $catalystGroup = new CatalystGroup;
        $catalystGroup->bio = $validated->bio;
        $catalystGroup->name = $validated->name;
        $catalystGroup->user_id = $validated->owner['id'];
        $catalystGroup->github = $validated->github;
        $catalystGroup->discord = $validated->discord;
        $catalystGroup->twitter = $validated->twitter;
        $catalystGroup->website = $validated->website;
        $catalystGroup->save();

        return to_route('catalystExplorer.myGroups');
    }

    public function update(Request $request, CatalystGroup $catalystGroup)
    {
        if (!$catalystGroup->id) {
            throw (new ModelNotFoundException())->setModel(CatalystGroup::class);
        }
        $request->validate([
            'email' => 'sometimes|email',
            'twitter' => 'nullable|bail|min:2',
            'github' => 'nullable|bail|min:5',
            'discord' => 'nullable|bail|min:4',
            'telegram' => 'nullable|bail|min:2',
        ]);

        $catalystGroup->bio = $request->bio;
        $catalystGroup->twitter = $request->twitter;
        $catalystGroup->github = $request->github;
        $catalystGroup->discord = $request->discord;
        $catalystGroup->save();

        return to_route('catalystExplorer.myGroups');
    }

    public function query()
    {
        $query = CatalystGroup::select('id', 'name', 'discord', 'twitter', 'website', 'github', 'slug')
            ->where('status', 'published')
            ->whereHas('proposals', fn ($q) => $q->whereNotNull('funded_at'))
            ->withSum([
                'proposals as amount_awarded_ada' => function ($query) {
                    $query->whereNotNull('funded_at')
                        ->whereHas('fund', function ($q) {
                            $q->where('currency', 'ADA');
                        });
                },
                'proposals as amount_awarded_usd' => function ($query) {
                    $query->whereNotNull('funded_at')
                        ->whereHas('fund', function ($q) {
                            $q->where('currency', 'USD');
                        });
                },
            ], 'amount_requested')
            ->withSum([
                'proposals as amount_received' => function ($query) {
                    $query->whereNotNull('funded_at');
                },
            ], 'amount_received')
            ->when($this->search, function ($query, $search) {
                return $query->where('name', 'iLIKE', "%{$search}%");
            })
            ->when($this->sort, function ($query, $sort) {
                $sortParts = explode(':', $sort);

                $sortBy = $sortParts[0];
                $sortDirection = $sortParts[1];

//                return $query->orderByRaw("ISNULL({$sortBy}), {$sortBy} {$sortDirection}");
                return $query->orderBy($sortBy, $sortDirection);
            });

        $paginator = $query->fastPaginate($this->perPage, ['*'], 'p')->setPath('/');

        $paginator->through(
            fn ($group) => [
                'id' => $group->id,
                'logo' => $group->thumbnail_url ?? $group->gravatar,
                'name' => $group->name,
                'twitter' => $group->twitter,
                'website' => $group->website,
                'github' => $group->github,
                'slug' => $group->slug,
                'discord' => $group->discord,
                'amount_awarded_ada' => $group->amount_awarded_ada,
                'amount_awarded_usd' => $group->amount_awarded_usd,
                'amount_received' => $group->amount_received,
            ]
        );

        return $paginator->onEachSide(1)->toArray();
    }
}
