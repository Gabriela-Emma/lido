<?php

namespace App\Http\Controllers\Api\CatalystExplorer;

use App\Http\Controllers\Controller;
use App\Http\Resources\PeopleResource;
use App\Models\Proposal;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Symfony\Component\HttpFoundation\Response;

class PeopleController extends Controller
{
    use Traits\People;

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
}
