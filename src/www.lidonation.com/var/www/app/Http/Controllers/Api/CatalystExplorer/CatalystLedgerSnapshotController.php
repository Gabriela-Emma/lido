<?php

namespace App\Http\Controllers\Api\CatalystExplorer;

use OpenApi\Annotations as OA;
use App\Http\Controllers\Controller;
use App\Models\CatalystLedgerSnapshot;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CatalystLedgerSnapshotController extends Controller
{

    /**
     * @OA\Get(
     *     path="/catalyst-ledger-snapshots",
     *     tags={"catalyst-ledger-snapshots"},
     *     summary="Get a list of catalyst-ledger-snapshots",
     *     description="Returns a list of all catalyst-ledger-snapshots",
     *     operationId="catalyst-ledger-snapshots",
     *
     *  
     *     @OA\Response(
     *         response=200,
     *         description="successful",
     *
     *         @OA\JsonContent(
     *             type="object",
     *
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *
     *                 @OA\Items(
     *                     ref="#/components/schemas/catalyst-ledger-snapshots"
     *                 )
     *             ),
     *
     *             @OA\Property(
     *                 property="links",
     *                 type="object",
     *                 ref="#/components/schemas/catalyst-ledger-snapshots_links"
     *             ),
     *             @OA\Property(
     *                 property="meta",
     *                 type="object",
     *                 ref="#/components/schemas/catalyst-ledger-snapshots_meta"
     *             )
     *         )
     *     ),
     * )
     */

    public function catalystLedgerSnapshots(): \Illuminate\Http\Response|AnonymousResourceCollection|Application|ResponseFactory
    {
        $per_page = request('per_page', 200);

        if ($per_page > 200) {
            return response([
                'status_code' => 400,
                'message' => 'query parameter \'per_page\' should not exceed 200'
            ], 400);
        }

        // if ($funds->get()->isEmpty()) {
        //     return response([
        //         'status_code' => 404,
        //         'message' => 'No challenge found',
        //     ], Response::HTTP_NOT_FOUND);
        // } else {
        //     return ChallengeResource::collection($funds->fastPaginate($per_page));
        // }
    }


    /**
     * @OA\Get(
     *     path="/challenges/{snapshot_id}",
     *     tags={"catalyst-ledger-snapshot"},
     *     summary="Get catalyst-ledger-snapshot by challenge id",
     *     description="Returns a single Archive snapshot.",
     *     operationId="snapshot",
     *
     *     @OA\Parameter(
     *         name="challenge_id",
     *         in="path",
     *         description="id of snapshot to return",
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
     *         description="CatalystLedgerSnapshots not found"
     *      ),
     *
     * )
     */

     
    public function challenge($challenge_id)
    {



        // Fund::withoutGlobalScopes();

        // $challenge = Fund::where('id', $challenge_id)
        //     ->whereNotNull('parent_id')
        //     ->first();

        // if (is_null($challenge)) {
        //     return response([
        //         'errors' => 'Challenge not found',
        //     ], Response::HTTP_NOT_FOUND);
        // }

        // return new ChallengeResource($challenge);
    }

}