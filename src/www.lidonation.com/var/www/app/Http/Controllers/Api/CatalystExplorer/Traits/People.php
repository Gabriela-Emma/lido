<?php

namespace App\Http\Controllers\Api\CatalystExplorer\Traits;

use App\Http\Resources\PeopleResource;
use App\Models\CatalystUser;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use OpenApi\Annotations as OA;

trait People
{
    /**
     * @OA\Get(
     *     path="/people",
     *     tags={"people"},
     *     summary="Get all people",
     *     description="Returns all people",
     *     operationId="people",
     *     @OA\Response(
     *         response=200,
     *         description="successful",
     *          @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     ref="#/components/schemas/people"
     *                 )
     *             ),
     *             @OA\Property(
     *                 property="links",
     *                 type="object",
     *                 @OA\Property(
     *                     ref="#/components/schemas/people_links"
     *                 )
     *             ),
     *             @OA\Property(
     *                 property="meta",
     *                 type="object",
     *                 @OA\Property(
     *                     ref="#/components/schemas/people_meta"
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function people(): Response|AnonymousResourceCollection|Application|ResponseFactory
    {
        $per_page = request('per_page', 24);

        // per_page query doesn't exceed 60
        //@todo revert this 400 back to 60
        if ($per_page > 400) {
            return response([
                'status_code' => 400,
                'message' => 'query parameter \'per_page\' should not exceed 60'], 400);
        }

        $proposals = CatalystUser::query()
            ->filter(request(['search', 'ids']));

        return PeopleResource::collection($proposals->paginate($per_page)->onEachSide(0));
    }

    public function claim(Request $request)
    {
        //
    }
}
