<?php

namespace App\Http\Controllers\Api\CatalystExplorer\Traits;

use App\Http\Resources\PeopleResource;
use App\Models\CatalystUser;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use OpenApi\Annotations as OA;
use App\Models\Meta;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

trait People
{
    /**
     * @OA\Get(
     *     path="/people",
     *     tags={"people"},
     *     summary="Get all people",
     *     description="Returns all people",
     *     operationId="people",
     *     @OA\Response(
     *         response=200,
     *         description="successful",
     *          @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     ref="#/components/schemas/people"
     *                 )
     *             ),
     *             @OA\Property(
     *                 property="links",
     *                 type="object",
     *                 @OA\Property(
     *                     ref="#/components/schemas/people_links"
     *                 )
     *             ),
     *             @OA\Property(
     *                 property="meta",
     *                 type="object",
     *                 @OA\Property(
     *                     ref="#/components/schemas/people_meta"
     *                 )
     *             )
     *         )
     *     )
     * )
     */
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

        $proposals = CatalystUser::query()
            ->filter(request(['search', 'ids']));

        return PeopleResource::collection($proposals->paginate($per_page)->onEachSide(0));
    }

    public function claim(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|email',
            'bio' => 'nullable'
        ]);
        $catUser = CatalystUser::where('id', $request->catalyst_id)?->first();
        $newUser = User::where('email', $request->email)?->first();
        if (! $newUser instanceof User) {
            $newUser = new User;
            $newUser->name = $request->name;
            $newUser->email = $request->email;
            $newUser->bio = $request->bio;
            $newUser->password = Hash::make(Str::random(30)) ?? null;
            $newUser->save();
        }

        

        $code = Str::random(5);

        $meta = new Meta;
        $meta->key = 'ideascale_verification_code';
        $meta->content = $code;
        $meta->model_type = User::class;
        $newUser->metas()->save($meta);

        $catMeta = new Meta;
        $catMeta->key = 'ideascale_verification_code';
        $catMeta->content = $code;
        $catMeta->model_type = CatalystUser::class;
        $catUser->metas()->save($catMeta);

        $input = $request->all();
        $jsonData = json_encode($input);

        $claimMeta = new Meta;
        $claimMeta->key = 'claim_data';
        $claimMeta->content = $jsonData;
        $claimMeta->model_type = CatalystUser::class;
        $catUser->metas()->save($claimMeta);


        return $code;

    }
}
