<?php

namespace App\Http\Controllers\Delegators;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Invokable;
use App\Http\Integrations\Blockfrost\Requests\BlockfrostRequest;
use App\Models\User;
use App\Services\CardanoBlockfrostService;
use DateTimeImmutable;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class DelegatorController extends Controller
{
    public function index(Request $request): array
    {
        return [];
    }

    public function login(Request $request): JsonResponse|Authenticatable|null
    {
        $credentials = $request->validate([
            'email' => 'nullable|bail|required_without:delegator|email',
            'password' => 'nullable|bail|required_without:delegator|min:5',
            'delegator' => 'sometimes|required_without_all:email,password|min:13',
            'key' => 'sometimes|required_without_all:email,password|min:13',
            'signature' => 'sometimes|required_without_all:email,password|min:13',
        ]);

        if ((bool) $request->delegator) {
            $user = User::where('wallet_stake_address', $request->delegator)->first();

            // since it's possible for an account not to have an email address.
            if ((bool) $user) {
                Auth::login($user, $remember = true);

                return auth()->user();
            } else {
                return response()->json([
                    'message' => 'We are having trouble logging you in with your stake address. Try your email and password or try registering again.',
                ], 401);
            }
        }

        if (Auth::attempt($credentials, $remember = true)) {
            return auth()->user();
        }

        return response()->json([
            'message' => 'We are having trouble logging you in with provided credentials.',
        ], 401);
    }

    public function logout(Request $request): ?Authenticatable
    {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return null;
    }

    public function current(Request $request): ?Authenticatable
    {
        return auth()->user();
    }

    public function create(Request $request): ?Authenticatable
    {
        return Invokable\CreateUserController::class;
        // $this->validate($request, [
        //     'name' => 'nullable|min:3',
        //     'email' => 'nullable|email|unique:users',
        //     'password' => 'nullable|min:5',
        //     'stake_address' => 'bail|required|min:13',
        // ]);
        // $user = LidoUser::where('email', $request->email)
        //     ->orWhere('wallet_stake_address', $request->stake_address)->first();

        // if (! $user instanceof LidoUser) {
        //     $user = new LidoUser;
        //     $user->name = $request->name;
        //     $user->email = $request->email ?? substr($request->stake_address, -4).'@anonymous.com';
        //     $user->password = Hash::make($request->password);
        //     $user->assignRole((string) RoleEnum::delegator());
        // }
        // $user->wallet_stake_address = $request->stake_address;
        // $user->wallet_address = $request->wallet_address;
        // $user->save();

        // Auth::login($user,$remember=true );

        // return auth()->user();
    }

    public function delegators(Request $request)
    {
        return Inertia::render('Home');
    }

    public function poolDetails()
    {
        $poolId = config('cardano.pool.hash');
        $frost = new BlockfrostRequest('/pools/'.$poolId);
        $details = $frost->send()->collect();

        return $details;
    }

    public function poolBlocks()
    {
        $poolId = config('cardano.pool.hash');
        $blocks = app(CardanoBlockfrostService::class)->request('get', '/pools/'.$poolId.'/blocks', ['count' => 21, 'order' => 'desc'])->collect();
        $mintedBlocks = $blocks->map(function ($block) {
            $res = app(CardanoBlockfrostService::class)->request('get', '/blocks/'.$block, null)->collect();

            return [
                'date' => (new DateTimeImmutable('@'.$res['time']))->format('m/d/Y H:i:s'),
                ...$res,
            ];
        })->all();

        return $mintedBlocks;
    }
}
