<?php

namespace App\Http\Controllers\Api\CatalystExplorer\Traits;

use App\Http\Resources\ProposalResource;
use App\Models\Proposal;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use OpenApi\Annotations as OA;

trait Proposals
{
    /**
     * @OA\Get(
     *     path="/proposals",
     *     tags={"proposal"},
     *     summary="Get all proposals",
     *     description="Returns all proposals with filtering abilities",
     *     operationId="proposals",
     *     @OA\Parameter(
     *         name="user_id",
     *         in="query",
     *         description="<p>Filters content by user_id<p>",
     *         required=false,
     *         @OA\Schema(
     *             type="integer"
     *         ),
     *     ),
     *     @OA\Parameter(
     *         name="challenge_id",
     *         in="query",
     *         description="<p>Filter content by challenge_id<p>",
     *         required=false,
     *         @OA\Schema(
     *             type="integer",
     *         ),
     *     ),
     *     @OA\Parameter(
     *         name="fund_id",
     *         in="query",
     *         description="<p>Filter content by fund_id<p>",
     *         required=false,
     *         @OA\Schema(
     *             type="integer",
     *         ),
     *     ),
     *     @OA\Parameter(
     *         name="search",
     *         in="query",
     *         description="<p> Filters content by title<p>",
     *         required=false,
     *         @OA\Schema(
     *             type="string",
     *         ),
     *     ),
     *     @OA\Parameter(
     *         name="per_page",
     *         in="query",
     *         description="<p>Number of content to be returned per page url ranging from 1 to 60<p>",
     *         required=false,
     *         @OA\Schema(
     *             type="integer",
     *             default=24,
     *             minimum=1,
     *             maximum=60
     *         ),
     *     ),
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         description="<p>Page number to be returned from content pages which is relative to the number of content to be returned and per_page setting as per the request<p>",
     *         required=false,
     *         @OA\Schema(
     *             type="integer",
     *              default=1,
     *         ),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful",
     *         @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="data", ref="#/components/schemas/proposals"),
     *              @OA\Property(property="links", ref="#/components/schemas/proposals_links"),
     *              @OA\Property(property="meta", ref="#/components/schemas/proposals_meta"),
     *         ),
     *     ),
     *      @OA\Response(
     *         response=400,
     *         description="Bad Request",
     *         @OA\JsonContent(
     *              type = "object",
     *              @OA\Property(property="status_code", type="string", example=404),
     *              @OA\Property(property="message", type="string", example="Detailed message of errors, when available")
     *         )
     *      ),
     *     @OA\Response(
     *         response=404,
     *         description="Not found",
     *         @OA\JsonContent(
     *              @OA\Property(property="status_code", type="string", example=404),
     *              @OA\Property(property="message", type="string", example="Detailed message of errors, when available")
     *         )
     *      ),
     * )
     */
    public function proposals(): Response|AnonymousResourceCollection|Application|ResponseFactory
    {
        $per_page = request('per_page', 24);

        // per_page query doesn't exceed 60
        //@todo revert this 400 back to 60
        if ($per_page > 400) {
            return response([
                'status_code' => 400,
                'message' => 'query parameter \'per_page\' should not exceed 60'], 400);
        }

        Proposal::withoutGlobalScopes();
        $proposals = Proposal::query()
            ->orderByDesc('id')
            ->filter(request(['search', 'user_id', 'fund_id', 'challenge_id']));

        return ProposalResource::collection($proposals->paginate($per_page)->onEachSide(0));
    }
}
