<?php

namespace App\Http\Controllers\Api\CatalystExplorer;

use App\Http\Controllers\Controller;
use App\Http\Resources\FundResource;
use App\Models\Fund;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\Response;

class FundController extends Controller
{
    /**
     * @OA\Get(
     *     path="/funds",
     *     tags={"fund"},
     *     summary="Get all funds",
     *     description="Returns all funds",
     *     operationId="funds",
     *
     *     @OA\Response(
     *         response=200,
     *         description="successful",
     *
     *          @OA\JsonContent(
     *             type="object",
     *
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *
     *                 @OA\Items(
     *                     ref="#/components/schemas/funds"
     *                 )
     *             ),
     *
     *             @OA\Property(
     *                 property="links",
     *                 type="object",
     *                 @OA\Property(
     *                     ref="#/components/schemas/funds_links"
     *                 )
     *             ),
     *             @OA\Property(
     *                 property="meta",
     *                 type="object",
     *                 @OA\Property(
     *                     ref="#/components/schemas/funds_meta"
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function funds(): \Illuminate\Http\Response|AnonymousResourceCollection|Application|ResponseFactory
    {
        $per_page = request('per_page', 24);

        // per_page query doesn't exceed 100
        if ($per_page > 60) {
            return response([
                'status_code' => 400,
                'message' => 'query parameter \'per_page\' should not exceed 60'], 400);
        }

        $funds = Fund::orderByDesc('launched_at')
            ->funds()
            ->filter(request(['search']));

        $collection = FundResource::collection($funds->fastPaginate($per_page));
        if ($collection->isEmpty() ) {
            return response([
                'status_code' => 404,
                'message' => 'no proposal found',
            ], Response::HTTP_NOT_FOUND);
        } else {
            return FundResource::collection($funds->fastPaginate($per_page));
        }
    }

    /**
     * @OA\Get(
     *     path="/funds/{fund_id}",
     *     tags={"fund"},
     *     summary="Get fund by id",
     *     description="Returns a single fund",
     *     operationId="fund",
     *
     *     @OA\Parameter(
     *         name="fund_id",
     *         in="path",
     *         description="id of fund to return",
     *         required=true,
     *
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="successful",
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Fund not found"
     *      ),
     *
     * )
     */
    public function fund($proposal_id): \Illuminate\Http\Response|FundResource|Application|ResponseFactory
    {
        $fund = Fund::find($proposal_id);

        if (is_null($fund)) {
            return response([
                'errors' => 'Fund not found',
            ], Response::HTTP_NOT_FOUND);
        } else {
            return new FundResource($fund);
        }
    }
}
