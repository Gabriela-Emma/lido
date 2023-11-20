<?php

namespace App\Inertia\CatalystExplorer;

use App\Http\Controllers\Controller;
use App\Models\CatalystExplorer\Group;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Fluent;
use Inertia\Inertia;
use Inertia\Response;
use Meilisearch\Endpoints\Indexes;

class GroupsController extends Controller
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

    public function create(Request $request): RedirectResponse
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

        $catalystGroup = new Group;
        $catalystGroup->bio = $validated->bio;
        $catalystGroup->name = $validated->name;
        $catalystGroup->user_id = $validated->owner['id'];
        $catalystGroup->github = $validated->github;
        $catalystGroup->discord = $validated->discord;
        $catalystGroup->twitter = $validated->twitter;
        $catalystGroup->website = $validated->website;
        $catalystGroup->save();

        return to_route('catalyst-explorer.myGroups');
    }

    public function update(Request $request, Group $catalystGroup): RedirectResponse
    {
        if (! $catalystGroup->id) {
            throw (new ModelNotFoundException())->setModel(Group::class);
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

        return to_route('catalyst-explorer.myGroups');
    }

    public function query(): array
    {
        $searchBuilder = Group::search(
            $this->search,
            function (Indexes $index, $query, $options) {
                $options['attributesToRetrieve'] = $attrs ?? [
                    'id',
                    'name',
                    'discord',
                    'twitter',
                    'website',
                    'github',
                    'link',
                    'amount_received',
                    'thumbnail_url',
                    'amount_awarded_ada',
                    'amount_awarded_usd',
                    'gravatar',
                ];
                if ((bool) $this->sort) {
                    $sortParts = explode(':', $this->sort);

                    $sortBy = $sortParts[0];
                    $sortDirection = $sortParts[1];
                    $options['sort'] = ["$sortBy:$sortDirection"];
                }

                $options['offset'] = (($this->currentPage ?? 1) - 1) * $this->perPage;
                $options['limit'] = $this->perPage;

                return $index->search($query, $options);
            }
        );

        $response = new Fluent($searchBuilder->raw());

        $pagination = new LengthAwarePaginator(
            $response->hits,
            $response->estimatedTotalHits,
            $response->limit,
            $this->currentPage,
            [
                'pageName' => 'p',
            ]
        );

        return $pagination->onEachSide(1)->toArray();

    }

    public function getFilteredData(Request $request)
    {
        $this->search = $request->input('s', null);
        $this->perPage = $request->input('l', 24);
        $this->sort = $request->input('st', null);
        $this->currentPage = $request->input('p', 1);

        return $this->query();
    }
}
