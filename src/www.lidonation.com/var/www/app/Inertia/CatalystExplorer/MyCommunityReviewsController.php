<?php

namespace App\Inertia\CatalystExplorer;

use App\DataTransferObjects\ProposalRatingData;
use App\Enums\CatalystExplorerQueryParams;
use App\Http\Controllers\Controller;
use App\Models\CatalystExplorer\Assessment;
use App\Models\CatalystExplorer\ProposalRating;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Inertia\Inertia;
use Inertia\Response;

class MyCommunityReviewsController extends Controller
{
    protected int $perPage = 24;

    protected int $currentPage;

    public Collection $fundsFilter;

    public function manage(Assessment $assessment)
    {
        return Inertia::modal('Auth/UserCommunityReviews')
            ->with([
                'proposal' => $assessment,
            ])
            ->baseRoute('catalyst-explorer.myCommunityReview');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $this->currentPage = $request->input('p', 1);
        $this->perPage = $request->input('l', 24);
        $this->fundsFilter = $request->collect(CatalystExplorerQueryParams::FUNDS)->map(fn ($n) => intval($n));

        return Inertia::render('Auth/UserCommunityReviews', $this->data());
    }

    protected function data()
    {
        $user = auth()->user();
        $user?->load('catalyst_users');
        $fundsFilterArray = $this->fundsFilter->toArray();

        $catalystProfiles = $user->catalyst_users?->pluck('id');
        $ratings = ProposalRating::with(['metas', 'proposal', 'community_review.comments'])
            ->orderBy('id')
            ->whereHas('proposal', function ($query) use ($catalystProfiles, $fundsFilterArray) {
                $query
                    ->withoutGlobalScopes()
                    ->where(function ($q) use ($fundsFilterArray) {
                        foreach ($fundsFilterArray as $fundId) {
                            $q->orWhereRelation('fund', 'parent_id', $fundId);
                        }
                    })
                    ->whereIn('proposals.user_id', $catalystProfiles);
            });

        // $reviews = Assessment::whereHas('discussion', function ($query) use ($catalystProfiles) {
        //     $query->whereHas('proposal', function ($discssionQuery) use ($catalystProfiles) {
        //         $discssionQuery
        //         ->withoutGlobalScopes()
        //         ->whereRelation('fund', 'parent_id', 113)
        //         ->whereIn('proposals.user_id', $catalystProfiles);
        //     });
        // });

        $paginator = $ratings->paginate($this->perPage, ['*'], 'p')
            ->through(fn ($m) => $m->setAppends(['meta_data']))
            ->setPath('/')
            ->onEachSide(1);

        // dd(ProposalRatingData::collection($paginator)->toArray());

        // dd(
        //     ProposalRatingData::collection($paginator)->through(fn ($rating) => [
        //         'id' => $rating->id,
        //         'rating' => $rating->rating,
        //     ])
        // );
        return [
            'filters' => [
                'funds' => $this->fundsFilter->toArray(),
            ],
            'proposalRatings' => ProposalRatingData::collection($paginator),
            'crumbs' => [
                ['label' => 'Profile'],
            ],
        ];
    }

    public function replyToReview(Request $request, Assessment $assessment)
    {
        $request->validate([
            'reply' => 'required|string',
        ]);

        $assessment->comments()->create([
            'commentator_id' => auth()->id(),
            'commentator_type' => User::class,
            'approved_at' => now(),
            // 'parent_id' => $request->input('parent_id'),
            'original_text' => $request->input('reply'),
            // 'model_type' => Discussion::class,
        ]);

        return redirect()->back();
    }

    public function destroyResponse(Assessment $assessment, Request $request)
    {
        $id = $request->resId;
        $comment = $assessment->comments()->find($id);

        if ($comment) {
            $comment->delete();
        }

        return redirect()->back();
    }

    public function editResponse(Assessment $assessment, Request $request)
    {
        $id = $request->resId;

        $comment = $assessment->comments()->find($id);

        $request->validate([
            'reply' => 'required|string',
        ]);

        $comment->original_text = $request->input('reply');

        $comment->save();

        return redirect()->back();
    }
}
