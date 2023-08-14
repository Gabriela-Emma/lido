<?php

namespace App\Http\Controllers\ProjectCatalyst;

use App\DataTransferObjects\ProposalRatingData;
use App\Http\Controllers\Controller;
use App\Models\Assessment;
use App\Models\ProposalRating;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class CatalystMyCommunityReviewsController extends Controller
{
    protected int $perPage = 36;

    protected int $currentPage;

    public function manage(Assessment $assessment)
    {
        return Inertia::modal('Auth/UserCommunityReviews')
            ->with([
                'proposal' => $assessment,
            ])
            ->baseRoute('catalystExplorer.myCommunityReview');
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

        return Inertia::render('Auth/UserCommunityReviews', $this->data());
    }

    protected function data()
    {
        $user = auth()->user();
        $user?->load('catalyst_users');

        $catalystProfiles = $user->catalyst_users?->pluck('id');
        $ratings = ProposalRating::with('metas')
            ->whereHas('proposal', function ($query) use ($catalystProfiles) {
            $query
                ->withoutGlobalScopes()
                ->whereRelation('fund', 'parent_id', 113)
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

        $paginator = $ratings->paginate($this->perPage, ['*'], 'p')->setPath('/')->onEachSide(1);

        return [
            'filters' => [

            ],
            'reviews' => ProposalRatingData::collection($paginator),
            'crumbs' => [
                ['label' => 'Profile'],
            ],
        ];
    }
}
