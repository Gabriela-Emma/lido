<?php

namespace App\Http\Controllers\Api\CatalystExplorer;

use App\Http\Controllers\Controller;
use App\Http\Resources\GroupResource;
use App\Models\CatalystGroup;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Symfony\Component\HttpFoundation\Response;

class GroupController extends Controller
{
    use Traits\Group;

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
