<?php

namespace App\Http\Controllers\ProjectCatalyst;

use Inertia\Inertia;
use Inertia\Response;
use Laravel\Scout\Builder;
use App\Models\CatalystUser;
use Illuminate\Http\Request;
use JetBrains\PhpStorm\ArrayShape;
use Meilisearch\Endpoints\Indexes;
use App\Http\Controllers\Controller;

class CatalystPeopleController extends Controller
{   
    public int $perPage = 24;

    public ?string $search = null;

    protected Builder $searchBuilder;

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {   
        $this->search=$request->input('s',null);

        return Inertia::render('People', [
            'search' => $this->search,
            'users' => $this->query($request),
            'crumbs' => [
                ['label' => 'People'],
            ],
        ]);
    }

    public function query(Request $request){
     
        $_options = [
            'filters' => array_merge([], $this->getUserFilters()),
        ];

        $this->searchBuilder = CatalystUser::search($this->search,
            function (Indexes $index, $query, $options) use ($_options) {
                if (count($_options['filters']) > 0) {
                    $options['filter'] = implode(' AND ', $_options['filters']);
                }
                $options['attributesToRetrieve'] = ['id'];
                if (! $this->search) {
                    $options['sort'] = ['name:asc'];
                }
                $options['limit'] = $this->perPage;

                return $index->search($query, $options);
            });
        $paginator = $this->searchBuilder->paginate($this->perPage);
        return [
            'data' => $paginator->map(fn ($user) => [
                'id' => $user->id,
                'name' => $user->name, 
                'link'=>$user->link,
                'profile_photo_url'=>$user->thumbnail_url ?? $user->gravatar,
                'proposals_count'=>$user->proposals_count,
            ]),
            'pagination' => $paginator->toArray(),
        ];
    }

    #[ArrayShape(['filters' => 'array'])]
    protected function getUserFilters(): array
    {
        $_options = [];

        return $_options;
    }
}
