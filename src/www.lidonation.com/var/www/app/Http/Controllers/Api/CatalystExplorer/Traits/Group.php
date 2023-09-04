<?php

namespace App\Http\Controllers\Api\CatalystExplorer\Traits;

use App\Http\Resources\GroupResource;
use App\Models\CatalystGroup;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use OpenApi\Annotations as OA;

trait Group
{
    /**
     * @OA\Get(
     *     path="/groups",
     *     tags={"group"},
     *     summary="Get all groups",
     *     description="Returns all groups",
     *     operationId="groups",
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
     *                     ref="#/components/schemas/groups"
     *                 )
     *             ),
     *
     *             @OA\Property(
     *                 property="links",
     *                 type="object",
     *                 @OA\Property(
     *                     ref="#/components/schemas/groups_links"
     *                 )
     *             ),
     *             @OA\Property(
     *                 property="meta",
     *                 type="object",
     *                 @OA\Property(
     *                     ref="#/components/schemas/groups_meta"
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function groups(): Response|AnonymousResourceCollection|Application|ResponseFactory
    {
        $per_page = request('per_page', 24);

        // per_page query doesn't exceed 60
        if ($per_page > 60) {
            return response([
                'status_code' => 60,
                'message' => 'query parameter \'per_page\' should not exceed 60'], 60);
        }

        $groups = CatalystGroup::query()
            ->filter(request(['search', 'ids']));

        return GroupResource::collection($groups->fastPaginate($per_page)->onEachSide(0));
    }
}
