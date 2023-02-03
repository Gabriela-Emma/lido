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
     *     @OA\Response(
     *         response=200,
     *         description="successful",
     *     ),
     *
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
            ->filter(request(['search', 'fund']));

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
     *     path="/challenges/{fund_id}",
     *     tags={"challenge"},
     *     summary="Get challenges by fund id",
     *     description="Returns challenges of a certain fund.",
     *     operationId="challenge",
     *     @OA\Parameter(
     *         name="fund_id",
     *         in="path",
     *         description="id of fund to return",
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
     *         description="Challenge(s) not found"
     *      ),
     *
     * )
     */
    public function challenge(Fund $fund): \Illuminate\Http\Response|ChallengeResource|Application|ResponseFactory
    {
        return new ChallengeResource($fund);
    }
}
