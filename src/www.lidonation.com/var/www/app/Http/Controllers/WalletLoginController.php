<?php

namespace App\Http\Controllers;

use App\Http\Integrations\Lucid\Requests\LucidRequest;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class WalletLoginController extends Controller
{
    public function login(Request $request): JsonResponse|Authenticatable|null
    {
        $credentials = $request->validate([
            'account' => 'sometimes|required_without_all:email,password|min:13',
            'key' => 'sometimes|required_without_all:email,password|min:13',
            'signature' => 'sometimes|required_without_all:email,password|min:13',
            'txHash' => 'sometimes|required_without_all:email,password,key,signature',
            'stakeAddrHex' => 'sometimes|required_without_all:email,password,key,signature',
        ]);

        if ($request->signature) {
            $validationResponse = $this->validateAddress(
                $request->key,
                $request->signature,
                null,
                $request->account,
                $request->stakeAddrHex
            );

        } else {
            $validationResponse = $this->validateAddress(
                null,
                null,
                $request->txHash,
                $request->account,
                $request->stakeAddrHex
            );
        }

        $user = User::where('wallet_stake_address', $credentials['account'])->first();

        // since it's possible for an account not to have an email address.
        if ($user instanceof User && $validationResponse) {
            Auth::login($user, $request->get('remember', false));

            if ($request->has('redirect') && Route::has($request->redirect)) {
                redirect()->route($request->redirect);
            }

            return auth()->user();
        }

        return response()->json([
            'message' => 'We are having trouble logging you in with your stake address. Try your email and password or try registering again.',
        ], 401);
    }

    public function validateAddress(
        string $key = null,
        string $signature = null,
        string $txHash = null,
        string $account = null,
        string $stakeAddrHex = null

    ) {
        $lucidReq = new LucidRequest('/wallet/authenticate', null);

        $lucidReq->body()->merge([
            'signature' => $signature,
            'key' => $key,
            'txHash' => $txHash,
            'stakeAddrHex' => $stakeAddrHex,
            'account' => $account,
        ]);

        return $lucidReq->send()->body();

    }
}
