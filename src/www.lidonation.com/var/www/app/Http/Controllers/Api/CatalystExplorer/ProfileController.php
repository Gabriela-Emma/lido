<?php

namespace App\Http\Controllers\Api\CatalystExplorer;

use App\Http\Controllers\Controller;
use App\Http\Resources\PeopleResource;
use App\Models\CatalystReport;
use App\Models\CatalystUser;
use App\Models\NotificationRequestTemplate;
use App\Models\Proposal;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use OpenApi\Annotations as OA;

class ProfileController extends Controller
{
    use Traits\People;
    /**
     * @OA\Get(
     *     path="/people/{person_id}",
     *     tags={"people"},
     *     summary="Get a person by id",
     *     description="Returns a single person",
     *     operationId="person",
     *     @OA\Parameter(
     *         name="person_id",
     *         in="path",
     *         description="id of the person to return",
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
     *         description="the person is not found"
     *      ),
     *
     * )
     */
    public function person($person_id): \Illuminate\Http\Response|PeopleResource|Application|ResponseFactory
    {
        $person = Proposal::find($person_id);

        if (is_null($person)) {
            return response([
                'errors' => 'Person not found',
            ], Response::HTTP_NOT_FOUND);
        } else {
            return new PeopleResource($person);
        }
    }

    public function  follow(CatalystUser $catalystProfile)
    {
        $who = Auth::user();

        $nrt = new NotificationRequestTemplate;
        $nrt->where = $who->email;
        $nrt->who_id = $who->id;
        $nrt->who_type = $who::class;

        $nrt->what_type = CatalystUser::class;
        $nrt->when = 'all';
        $nrt->what_filter = ['subject' => $catalystProfile->id];
        $nrt->status = 'published';

        $nrt->save();

        return $nrt;
    }
}
