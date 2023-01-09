<?php

namespace App\Http\Controllers\Api\Phuffycoin;

use App\Http\Controllers\Controller;
use App\Http\Resources\MintTxCollection;
use App\Models\MintTx;
use App\Services\CardanoBlockfrostService;
use App\Services\CardanoWalletService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Fluent;

class PhuffycoinController extends Controller
{
    public function index(Request $request)
    {
        return response(new MintTxCollection(auth()->user()?->mint_txs), 200);
    }

    public function available(Request $request)
    {
        return MintTx::where([
            'user_id' => auth()?->user()?->getAuthIdentifier(),
            'status' => 'pending',
        ])->with('mint')
            ->get();
    }

    public function mintAddress()
    {
        $response = $this->mintAddressFromLucid();

        return response([
            'address' => $response?->address,
            'qr' => CardanoWalletService::generateQrCode($response?->address)
        ], 200);
    }

    public function claimStatus(Request $request, CardanoBlockfrostService $blockfrostService)
    {
        $user = auth()->user();
        $mintTxs = $user->mint_txs()->where('status', 'processing')->get();
        $mintTxsMinting = $user->mint_txs()->where('status', 'minting')->get();
        if ($mintTxs->isEmpty() && $mintTxsMinting->isEmpty()) {
            return response('No claim started.', 404);
        }

        if ($mintTxsMinting->isEmpty()) {
            $depositTx = $mintTxs->first()?->meta_data?->deposit_tx;
            $txDetail = $blockfrostService->get("txs/${depositTx}", null)->json();
            $txUtxos = $blockfrostService->get("txs/${depositTx}/utxos", null)->object();

            $depositAddress = collect($txUtxos->inputs ?? null)?->first()?->address;
            $txTime = isset($txDetail['block_time']) ? Carbon::parse($txDetail['block_time']) : null;

            if ($txTime && Carbon::now()->diffInMinutes($txTime) >= 75) {
                return response(['message' => 'Deposit transaction have expired'], 400);
            }

            $dbDepositAddress = $mintTxs->first()?->meta_data?->deposit_address;
            if ($depositAddress != $dbDepositAddress) {
                if (!!$dbDepositAddress) {
                    return response(['message' => 'Deposit address mismatch.'], 400);
                } else {
                    $mintTxs->each(function ($tx) use ($depositAddress) {
                        if ($depositAddress) {
                            $tx->saveMeta('deposit_address', $depositAddress, $tx);
                        }
                    });
                }
            }

            $mintAddress = new Fluent($this->mintAddressFromLucid());
            if (!collect($txUtxos->outputs ?? null)->contains('address', $mintAddress?->address)) {
                return response(new MintTxCollection($user->mint_txs));
            }

            // trigger mint
            if ($mintTxs->first()?->status == 'processing') {
                $this->mint($depositAddress);
            }
        } else {
            // update statuses to minted
            $mintTxs = MintTx::lockForUpdate()->where('user_id', $user->id)->where('status', '!=', 'minted')->get();
            $mintTx = $mintTxs->first();

            if ($mintTx->status === 'minting') {
                $mintingTx = $mintTx->meta_data?->minting_tx;
                if ($mintingTx) {
                    $txUtxos = $blockfrostService->get("txs/${mintingTx}/utxos", null);
                    if ($txUtxos->successful()) {
                        $mintTxs->each(function ($tx) {
                            $tx->status = 'minted';
                            $tx->save();
                        });
                    }
                }
            }
        }

        return response(new MintTxCollection($user->mint_txs()->get()), 200);
    }

    protected function mintAddressFromLucid()
    {
        $seed = file_get_contents("/data/phuffycoin/wallets/mint/seed.txt");

        try {
            return Http::post(
                config('cardano.lucidEndpoint') . '/wallet/address',
                compact('seed')
            )->throw()->object();
        } catch (Exception $e) {
            return null;
        }
    }

    // mint phuffycoin and submit to chain
    protected function mint($userAddress)
    {
        $user = auth()->user();
        $seed = file_get_contents("/data/phuffycoin/wallets/mint/seed.txt");
        try {
            $mintTxs = MintTx::lockForUpdate()->where('user_id', $user->id)->where('status', '!=', 'minted')->get();
            $mintTx = $mintTxs->first();
            $mintAmount = $mintTxs->sum('amount');

            // connect to lucid backend and mint coin
            $response = Http::post(
                config('cardano.lucidEndpoint') . '/phuffycoin/claim',
                [
                    'userAddress' => $userAddress,
                    'phuffyAmount' => $mintAmount,
                    'msg' => $mintTx->mint?->memo,
                    'seed' => $seed
                ]
            )->throw()->object();
            $mintTxs->each(function ($tx) use ($response) {
                // update statuses to minting
                $tx->saveMeta('minting_tx', $response->tx, $tx);
                $tx->status = 'minting';
                $tx->save();
            });

            // return results to user
            return $response;
        } catch (Exception $e) {
            return $e;
        }
    }

    public function claim(Request $request, CardanoBlockfrostService $blockfrostService)
    {
        $request->validate([
            'mintTxs' => 'required',
            'depositTx' => 'required',
        ]);

        $depositTx = $request->input('depositTx');
        $mintTxs = $request->input('mintTxs');
        $txUtxos = $blockfrostService->get("txs/${depositTx}/utxos", null)->object();
        if (empty($mintTxs)) {
            return response('Invalidate mint data.', 400);
        }
        $mintTxs = MintTx::lockForUpdate()->find($mintTxs);
        $depositAddress = collect($txUtxos->inputs ?? null)->first()?->address;
        $mintTxs->each(function ($tx) use ($depositTx, $depositAddress) {
            $tx->saveMeta('deposit_tx', $depositTx, $tx);
            if ($depositAddress) {
                $tx->saveMeta('deposit_address', $depositAddress, $tx);
            }
            $tx->status = 'processing';
            $tx->save();
        });

        return response(new MintTxCollection(MintTx::find($request->input('mintTxs'))));
    }

}
