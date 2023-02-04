<?php

namespace App\Http\Controllers\Api\CatalystExplorer;

use App\Http\Controllers\Controller;
use App\Http\Resources\ChallengeResource;
use App\Models\Fund;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\Response;

class ChallengeController extends Controller
{
    /**
     * @OA\Get(
     *     path="/challenges",
     *     tags={"challenge"},
     *     summary="Get a list of challenges",
     *     description="Returns a list of all challenges",
     *     operationId="challenges",
     *      @OA\Parameter(
     *         name="fund_id",
     *         in="query",
     *         description="Filter content by id of a fund",
     *         required=false,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         ),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     ref="#/components/schemas/challenges"
     *                 )
     *             ),
     *             @OA\Property(
     *                 property="links",
     *                 type="object",
     *                 ref="#/components/schemas/challenges_links"
     *             ),
     *             @OA\Property(
     *                 property="meta",
     *                 type="object",
     *                 ref="#/components/schemas/challenges_meta"
     *             )
     *         )
     *     ),
     * )
     */
    public function challenges(): \Illuminate\Http\Response|AnonymousResourceCollection|Application|ResponseFactory
    {
        $per_page = request('per_page', 200);

        if ($per_page > 200) {
            return response([
                'status_code' => 400,
                'message' => 'query parameter \'per_page\' should not exceed 200'], 400);
        }

        Fund::withoutGlobalScopes();
        $funds = Fund::challenges()->orderBy('title')
            ->filter(request(['search', 'fund_id']));

        if ($funds->get()->isEmpty()) {
            return response([
                'status_code' => 404,
                'message' => 'No challenge found',
            ], Response::HTTP_NOT_FOUND);
        } else {
            return ChallengeResource::collection($funds->paginate($per_page));
        }
    }

    /**
     * @OA\Get(
     *     path="/challenges/{challenge_id}",
     *     tags={"challenge"},
     *     summary="Get challenge by challenge id",
     *     description="Returns a single challenge.",
     *     operationId="challenge",
     *     @OA\Parameter(
     *         name="challenge_id",
     *         in="path",
     *         description="id of challenge to return",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful",
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Challenge not found"
     *      ),
     *
     * )
     */
    public function challenge($challenge_id): \Illuminate\Http\Response|ChallengeResource|Application|ResponseFactory
    {
        Fund::withoutGlobalScopes();

        $challenge = Fund::where('id', $challenge_id)
            ->whereNotNull('parent_id')
            ->first();

        if (is_null($challenge)) {
            return response([
                'errors' => 'Challenge not found',
            ], Response::HTTP_NOT_FOUND);
        }

        return new ChallengeResource($challenge);
    }
}
