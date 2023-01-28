<?php

namespace App\Http\Controllers\Api\CatalystExplorer;

use App\Http\Controllers\Controller;
use App\Http\Resources\TagResource;
use App\Models\Tag;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\Response;

class TagController extends Controller
{
    public function tags(): \Illuminate\Http\Response|AnonymousResourceCollection|Application|ResponseFactory
    {
        $per_page = request('per_page', 100);

        if ($per_page > 100) {
            return response([
                'status_code' => 400,
                'message' => 'query parameter \'per_page\' should not exceed 100'], 400);
        }
        $tags = Tag::whereHas('proposals')->orderBy('title')
            ->filter(request(['search', 'ids']));

        if ($tags->get()->isEmpty()) {
            return response([
                'status_code' => 404,
                'message' => 'No Tag found',
            ], Response::HTTP_NOT_FOUND);
        } else {
            return TagResource::collection($tags->paginate($per_page));
        }
    }

    public function tag(Tag $tag): \Illuminate\Http\Response|TagResource|Application|ResponseFactory
    {
        return new TagResource($tag);
    }
}
