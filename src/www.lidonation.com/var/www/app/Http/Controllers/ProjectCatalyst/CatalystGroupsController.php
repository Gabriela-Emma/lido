<?php

namespace App\Http\Controllers\ProjectCatalyst;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\CatalystGroup;
use App\Http\Controllers\Controller;
use Inertia\Response;
use Illuminate\Pagination\LengthAwarePaginator;

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

    public function query()
    {
        $query = CatalystGroup::select('id', 'name', 'discord', 'twitter', 'website', 'github', 'slug')
            ->where('status', 'published')
            ->whereHas('proposals', fn($q) => $q->whereNotNull('funded_at'))
            ->withSum([
                'proposals as amount_awarded' => function ($query) {
                    $query->whereNotNull('funded_at');
                }
            ], 'amount_requested')
            ->withSum([
                'proposals as amount_received' => function ($query) {
                    $query->whereNotNull('funded_at');
                }
            ], 'amount_received')
            ->when($this->search, function ($query, $search) {
                return $query->where('name', 'iLIKE', "%{$search}%");
            })
            ->when($this->sort, function ($query, $sort) {
                $sortParts = explode(':', $sort);
                return $query->orderBy($sortParts[0], $sortParts[1]);
            });

        $paginator = $query->paginate($this->perPage, ['*'], 'p')->setPath('/');

        $paginator->through(fn($group) => [
            'id' => $group->id,
            'logo' => $group->thumbnail_url ?? $group->gravatar,
            'name' => $group->name,
            'twitter' => $group->twitter,
            'website' => $group->website,
            'github' => $group->github,
            'slug' => $group->slug,
            'discord' => $group->discord,
            'amount_awarded' => $group->amount_awarded,
            'amount_received' => $group->amount_received
        ]
        );

        return $paginator->onEachSide(1)->toArray();
    }

}
