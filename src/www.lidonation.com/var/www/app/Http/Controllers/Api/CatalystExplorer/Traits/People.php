<?php

namespace App\Http\Controllers\Api\CatalystExplorer\Traits;

use App\Http\Resources\PeopleResource;
use App\Models\CatalystUser;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

trait People
{
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

//        CatalystUser::withoutGlobalScopes();
        $proposals = CatalystUser::query()
            ->filter(request(['search', 'ids']));

        return PeopleResource::collection($proposals->paginate($per_page)->onEachSide(0));
    }
}
