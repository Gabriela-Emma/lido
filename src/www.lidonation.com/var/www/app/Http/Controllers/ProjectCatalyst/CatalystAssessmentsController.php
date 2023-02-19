<?php

namespace App\Http\Controllers\ProjectCatalyst;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProposalResource;
use App\Models\Assessment;
use App\Models\CatalystReport;
use App\Models\CatalystUser;
use App\Models\Discussion;
use App\Models\Proposal;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Fluent;
use Inertia\Inertia;
use Inertia\Response;
use JetBrains\PhpStorm\ArrayShape;
use Meilisearch\Endpoints\Indexes;

class CatalystAssessmentsController extends Controller
{
    public int $perPage = 25;
    public ?string $search = null;
    public ?int $currentPage;


    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $this->search = $request->input('s', null);
        $this->perPage = $request->input('l', 24);
        $this->currentPage = $request->input('p', 1);

        // props
        $props = [
            'search' => $this->search,
            'perPage' => $this->perPage,
            'assessments' => $this->query($request),
            'crumbs' => [
                ['label' => 'People'],
            ],
        ];
        if ($this->currentPage > 1) {
            $props['currPage'] = $this->currentPage;
        }

        return Inertia::render('Assessments', $props);
    }

    protected function query(Request $request)
    {
        $_options = [
            'filters' => array_merge([], $this->getUserFilters()),
        ];

        $searchBuilder = Assessment::search($this->search,
            function (Indexes $index, $query, $options) use ($_options) {
                if (count($_options['filters']) > 0) {
                    $options['filter'] = implode(' AND ', $_options['filters']);
                }
                $options['attributesToRetrieve'] = [
                    'id',
                    'label',
                    'rationale',
                    'proposal'
                ];
                if (!$this->search) {
                    $options['sort'] = ['rating:desc'];
                }
                $options['offset'] = (($this->currentPage ?? 1) - 1) * $this->perPage;
                $options['limit'] = $this->perPage;
                return $index->search($query, $options);
            });

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
//        $query = Assessment::with(['model.model.author'])
//            ->whereRelation('model', 'model_type','=', Proposal::class);
//        if (isset($this->search)) {
//            $query->orWhereFullText('content', $this->search)
//                ->orWhereHas('model', fn ($q) => $q->where('title', 'iLIKE', "%{$this->search}%"))
//                ->whereRelation('model.model.author', 'username', 'iLIKE', "%{$this->search}%"
////                    fn ($q) => $q->where('username', 'iLIKE', "%{$this->search}%")
//                );
//        }
//        dd(
//            $query->first()?->model?->model_type
//        );
//        dd(
//            collect(
//                $query->first()?->model?->model?->toSearchableArray()
//            )->only(['id', 'slug', 'title', 'users', 'fund', 'challenge', 'groups', 'funded', 'completed', 'challenge_label'])
//        );
//        $paginator = $query->paginate($this->perPage)->through(fn($assessment) => [
//            'rationale' => $assessment->content,
//            'title' => $assessment->model?->title,
//            'proposal' => [
//                'id' => $assessment->model?->model?->id,
//                'slug' => $assessment->model?->model?->slug,
//                'title' => $assessment->model?->model?->title,
//            ]
//        ]);
//
//        return $paginator->toArray();
    }

    #[ArrayShape(['filters' => 'array'])]
    protected function getUserFilters(): array
    {
        $_options = [];

        return $_options;
    }
}
