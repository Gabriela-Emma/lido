<?php

namespace App\Http\Controllers\Api\CatalystExplorer;

use App\Http\Controllers\Controller;
use App\Http\Resources\ChallengeResource;
use App\Models\Fund;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\Response;

class ChallengeController extends Controller
{
    public function challenges(): \Illuminate\Http\Response|AnonymousResourceCollection|Application|ResponseFactory
    {
        $per_page = request('per_page', 200);

        if ($per_page > 200) {
            return response([
                'status_code' => 400,
                'message' => 'query parameter \'per_page\' should not exceed 100'], 400);
        }

        Fund::withoutGlobalScopes();
        $funds = Fund::challenges()->orderBy('title')
            ->filter(request(['search', 'fund']));

        if ($funds->get()->isEmpty()) {
            return response([
                'status_code' => 404,
                'message' => 'No challenge found',
            ], Response::HTTP_NOT_FOUND);
        } else {
            return ChallengeResource::collection($funds->paginate($per_page));
        }
    }

    public function challenge(Fund $fund): \Illuminate\Http\Response|ChallengeResource|Application|ResponseFactory
    {
        return new ChallengeResource($fund);
    }
}
