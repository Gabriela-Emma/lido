<?php

namespace App\Http\Controllers\Api\CatalystExplorer\Traits;

use App\Http\Resources\GroupResource;
use App\Models\CatalystGroup;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

trait Group
{
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

        return GroupResource::collection($groups->paginate($per_page)->onEachSide(0));
    }
}
