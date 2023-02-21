<?php

namespace App\Http\Controllers\Api\CatalystExplorer;

use App\Http\Controllers\Controller;
use App\Http\Resources\TagResource;
use App\Models\Tag;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\Response;

class TagController extends Controller
{
    /**
     * @OA\Get(
     * path="/tags",
     * tags={"tag"},
     * summary="Get a list of tags",
     * description="Returns a list of all tags",
     * operationId="tags",
     *
     * @OA\Response(
     * response=200,
     * description="successful",
     *
     * @OA\JsonContent(
     * type="object",
     *
     * @OA\Property(
     * property="data",
     * type="array",
     *
     * @OA\Items(
     * ref="#/components/schemas/tags"
     * )
     * ),
     *
     * @OA\Property(
     * property="links",
     * type="object",
     * @OA\Property(
     * ref="#/components/schemas/tags_links"
     * )
     * ),
     * @OA\Property(
     * property="meta",
     * type="object",
     * @OA\Property(
     * ref="#/components/schemas/tags_meta"
     * )
     * )
     * )
     * )
     * )
     */
    public function tags(): \Illuminate\Http\Response|AnonymousResourceCollection|Application|ResponseFactory
    {
        $per_page = request('per_page', 200);

        if ($per_page > 200) {
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

    /**
     * @OA\Get(
     *     path="/tags/{tag}",
     *     tags={"tag"},
     *     summary="Retrieve a single tag",
     *     description="Use this endpoint to retrieve a single tag",
     *     operationId="tag",
     *
     *     @OA\Parameter(
     *         name="tag",
     *         in="path",
     *         description="title of the tag to retrieve",
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
     *         description="Tag not found"
     *      ),
     *
     * )
     */
    public function tag(Tag $tag): \Illuminate\Http\Response|TagResource|Application|ResponseFactory
    {
        return new TagResource($tag);
    }
}
