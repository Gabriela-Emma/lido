<?php

namespace App\Http\Controllers\Api\CatalystExplorer;

use App\Http\Controllers\Controller;
use App\Http\Resources\CatalystLedgerSnapshotResource;
use App\Models\CatalystLedgerSnapshot;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\Response;

class CatalystLedgerSnapshotController extends Controller
{
    /**
     * @OA\Get(
     *     path="/ledger-snapshots",
     *     tags={"ledger-snapshots"},
     *     summary="Get a list of ledger-snapshots",
     *     description="Returns a list of all ledger-snapshots",
     *     operationId="catalystLedgerSnapshot",
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
     *                     ref="#/components/schemas/catalystLedgerSnapshot"
     *                 )
     *             ),
     *
     *             @OA\Property(
     *                 property="links",
     *                 type="object",
     *                 @OA\Property(
     *                     ref="#/components/schemas/catalystLedgerSnapshots_links"
     *                 )
     *             ),
     *             @OA\Property(
     *                 property="meta",
     *                 type="object",
     *                 @OA\Property(
     *                     ref="#/components/schemas/catalystLedgerSnapshots_meta"
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function catalystLedgerSnapshots(): \Illuminate\Http\Response|AnonymousResourceCollection|Application|ResponseFactory
    {
        $per_page = request('per_page', 24);

        if ($per_page > 60) {
            return response([
                'status_code' => 400,
                'message' => 'query parameter \'per_page\' should not exceed 60',
            ], 400);
        }

        if (request()->has('search')) {
            $snapshots = CatalystLedgerSnapshot::search(request('search'))->query(
                fn (Builder $query) => $query->filter(request(['ids']))
            );
        } else {
            $snapshots = CatalystLedgerSnapshot::query()->fastPaginate($per_page)->onEachSide(0);
        }

        return CatalystLedgerSnapshotResource::collection($snapshots);
    }

    /**
     * @OA\Get(
     *     path="/ledger-snapshots/{snapshot_id}",
     *     tags={"ledger-snapshots"},
     *     summary="Get ledger-snapshot by snapshot id",
     *     description="Returns a single Archive snapshot.",
     *     operationId="catalystLedgerSnapshots",
     *
     *     @OA\Parameter(
     *         name="snapshot_id",
     *         in="path",
     *         description="id of snapshot to return",
     *         required=true,
     *
     *         @OA\Schema(
     *             type="string",
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="successful",
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="CatalystLedgerSnapshot not found"
     *      ),
     *
     * )
     */
    public function catalystLedgerSnapshot($snapshot_id)
    {

        $snapshot = CatalystLedgerSnapshot::where('snapshot_id', $snapshot_id)
            ->first();

        if (is_null($snapshot)) {
            return response([
                'errors' => 'CatalystLedgerSnapshot not found',
            ], Response::HTTP_NOT_FOUND);
        }

        return new CatalystLedgerSnapshotResource($snapshot);
    }

    // /**
    //  * @OA\Get(
    //  *     path="/ledger-snapshots/latest",
    //  *     tags={"ledger-snapshots"},
    //  *     summary="Get latest ledger-snapshot ",
    //  *     description="Returns a single Archive snapshot.",
    //  *     operationId="LatestCatalystLedgerSnapshots",
    //  *
    //  *
    //  *     @OA\Response(
    //  *         response=200,
    //  *         description="successful",
    //  *     ),
    //  *     @OA\Response(
    //  *         response=404,
    //  *         description="CatalystLedgerSnapshot not found"
    //  *      ),
    //  *
    //  * )
    //  */
    public function latestCatalystLedgerSnapshot()
    {

        $snapshot = CatalystLedgerSnapshot::query()->first();

        return new CatalystLedgerSnapshotResource($snapshot);
    }
}
