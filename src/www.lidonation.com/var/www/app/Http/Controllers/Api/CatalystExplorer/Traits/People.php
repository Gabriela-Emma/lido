<?php

namespace App\Http\Controllers\Api\CatalystExplorer\Traits;

use App\Http\Resources\PeopleResource;
use App\Models\CatalystUser;
use App\Models\Meta;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use OpenApi\Annotations as OA;

trait People
{
    /**
     * @OA\Get(
     *     path="/people",
     *     tags={"people"},
     *     summary="Get all people",
     *     description="Returns all people",
     *     operationId="people",
     *
     *     @OA\Response(
     *         response=200,
     *         description="successful",
     *
     *          @OA\JsonContent(
     *             type="object",
     *
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *
     *                 @OA\Items(
     *                     ref="#/components/schemas/people"
     *                 )
     *             ),
     *
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
            'bio' => 'nullable',
        ]);

        if (Auth::check()) {
            $lidoUser = Auth::user();
        } else {
            $lidoUser = User::where('email', $request->email)?->first();
        }
        if (! $lidoUser instanceof User) {
            $lidoUser = new User;
            $lidoUser->name = $request->name;
            $lidoUser->email = $request->email;
            $lidoUser->bio = $request->bio;
            $lidoUser->password = Hash::make(Str::random(30)) ?? null;
            $lidoUser->save();
        }

        $code = Str::random(5);

        $meta = new Meta;
        $meta->key = 'ideascale_verification_code';
        $meta->content = $code;
        $meta->model_type = User::class;
        $meta->model_id = $lidoUser->id;
        $meta->save();

        $catUser = CatalystUser::where('id', $request->catalyst_profile_id)?->first();
        $catMeta = new Meta;
        $catMeta->key = 'ideascale_verification_code';
        $catMeta->content = $code;
        $catMeta->model_type = CatalystUser::class;
        $catMeta->model_id = $catUser->id;
        $catMeta->save();

        $input = $request->all();
        $jsonData = json_encode($input);

        $claimMeta = new Meta;
        $claimMeta->key = 'claim_data';
        $claimMeta->content = $jsonData;
        $claimMeta->model_type = CatalystUser::class;
        $claimMeta->model_id = $catUser->id;
        $claimMeta->save();

        return $code;
    }
}
