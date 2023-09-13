<?php

namespace App\Http\Controllers\Api\Partners;

use App\Enums\RoleEnum;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Invokable\CreateUserController;
use App\Models\User;
use Exception;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class PartnersController extends Controller
{
    protected array $rules = [];

    public function login(Request $request): JsonResponse|Authenticatable|null
    {
        $credentials = $request->validate([
            'email' => 'nullable|bail|required_without:partner|email',
            'password' => 'nullable|bail|required_without:partner|min:5',
            'partner' => 'sometimes|required_without_all:email,password|min:13',
            'key' => 'sometimes|required_without_all:email,password|min:13',
            'signature' => 'sometimes|required_without_all:email,password|min:13',
        ]);

        if ((bool) $request->partner) {
            $user = User::where('wallet_stake_address', $request->partner)->firstOrFail();
            $isPartner = $user->hasRole(RoleEnum::partner()->value);

            // I think just call our lucid backand verity the signed using their helper function
            // since it's possible for an account not to have an email address.
            if ((bool) $user && $isPartner) {
                Auth::login($user, $remember = 1);

                return auth()->user();
            } else {
                return response()->json([
                    'message' => 'We are having trouble logging you in with your stake address. Try your email and password or try registering again.',
                ], 401);
            }
        }

        if (Auth::attempt([
            'email' => $request->email,
            'password' => $request->password,
        ], $remember = 1)) {
            return auth()->user();
        }

        return response()->json([
            'message' => 'We are having trouble logging you in with provided credentials.',
        ], 401);
    }

    public function policies(Request $request)
    {
        $seed = file_get_contents('/data/nfts/lido-minute/wallets/mint/seed.txt');
        try {
            $res = Http::post(
                config('cardano.lucidEndpoint').'/lido-minute/policy-id',
                compact('seed')
            )->throw()->object();

            return [$res->policy];
        } catch (Exception $e) {
            return null;
        }
    }

    public function logout(Request $request): ?Authenticatable
    {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return null;
    }

    public function create(Request $request)
    {
        return (new CreateUserController)($request);
    }
}
