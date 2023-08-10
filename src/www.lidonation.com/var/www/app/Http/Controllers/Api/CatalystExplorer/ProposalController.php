<?php

namespace App\Http\Controllers\Api\CatalystExplorer;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProposalResource;
use App\Models\Proposal;
use Illuminate\Http\Request;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use OpenApi\Annotations as OA;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class ProposalController extends Controller
{
    use Traits\Proposals;

    /**
     * @OA\Get(
     *     path="/proposals/{proposal_id}",
     *     tags={"proposal"},
     *     summary="Get proposal by id",
     *     description="Returns a single proposal",
     *     operationId="proposal",
     *
     *     @OA\Parameter(
     *         name="proposal_id",
     *         in="path",
     *         description="id of proposal to return",
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
     *         description="Proposal not found"
     *      ),
     *
     * )
     */
    public function proposal($proposal_id): \Illuminate\Http\Response|ProposalResource|Application|ResponseFactory
    {
        $proposal = Proposal::find($proposal_id);

        if (is_null($proposal)) {
            return response([
                'errors' => 'Proposal not found',
            ], Response::HTTP_NOT_FOUND);
        }

        return new ProposalResource($proposal);
    }

    public function storeQuickpitch(Request $request, Proposal $proposal)
    {
        $qp = $request->input('quickpitch');

        // get video id from youtube url
        if (Str::contains($qp, ['youtube', '?v='])) {

            if (Str::contains($qp, '?v=')) {
                $qp = Str::before(Str::after($qp, '?v='), '&');
            } elseif(Str::contains($qp, 'youtu.be/')) {
                $qp = Str::after($qp, 'youtu.be/');
            }
            $qp = 'https://youtu.be/' . $qp;
        }
        $proposal->quickpitch = $qp;
        $proposal->save();

        return $proposal->quickpitch;
    }
}
