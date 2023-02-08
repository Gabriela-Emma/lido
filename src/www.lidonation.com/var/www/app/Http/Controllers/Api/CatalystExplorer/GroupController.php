<?php

namespace App\Http\Controllers\Api\CatalystExplorer;

use App\Http\Controllers\Controller;
use App\Http\Resources\GroupResource;
use App\Models\CatalystGroup;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Symfony\Component\HttpFoundation\Response;
use OpenApi\Annotations as OA;

class GroupController extends Controller
{
    use Traits\Group;

    /**
     * @OA\Get(
     *     path="/groups/{group_id}",
     *     tags={"group"},
     *     summary="Get group by id",
     *     description="Returns a single group",
     *     operationId="group",
     *     @OA\Parameter(
     *         name="group_id",
     *         in="path",
     *         description="id of group to return",
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
     *         description="group not found"
     *      ),
     *
     * )
     */
    public function group($groupId): \Illuminate\Http\Response|GroupResource|Application|ResponseFactory
    {
        $group = CatalystGroup::find($groupId);

        if (is_null($group)) {
            return response([
                'errors' => 'Group not found',
            ], Response::HTTP_NOT_FOUND);
        } else {
            return new GroupResource($group);
        }
    }
}
