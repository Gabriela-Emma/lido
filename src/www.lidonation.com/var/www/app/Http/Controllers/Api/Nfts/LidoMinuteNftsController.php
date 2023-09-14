<?php

namespace App\Http\Controllers\Api\Nfts;

use App\Http\Controllers\Controller;
use App\Http\Resources\TxResource;
use App\Models\Nft;
use App\Models\Podcast;
use App\Models\Tx;
use App\Repositories\AdaRepository;
use App\Services\CardanoWalletService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class LidoMinuteNftsController extends Controller
{
    protected array $rules = [];

    public function paymentStatus()
    {
        // return $tx object from db
    }

    public function mint(Request $request)
    {
        $this->rules['hash'] = 'required|string|min:10';
        $this->rules['episode'] = 'required|int';
        $this->validate($request, $this->rules);

        // get a random available nft
        $podcast = Podcast::find($request->input('episode'));
        $nfts = $podcast->available_nfts;

        $hash = $request->input('hash');

        $tx = new Tx;
        $tx->hash = $hash;
        $tx->model_id = $nfts->first()?->id;
        $tx->model_type = Nft::class;
        $tx->save();

        return $tx;
    }

    public function mintPrice(): int
    {
        $quote = app(AdaRepository::class)->quote();

        return ceil(100 / $quote?->price);
    }

    public function mintAddress()
    {
        $response = $this->mintAddressFromLucid();

        return response([
            'address' => $response?->address,
            'qr' => CardanoWalletService::generateQrCode($response?->address),
        ], 200);
    }

    public function mintStatus(Request $request): TxResource
    {
        $address = $request->input('address');
        $tx = Tx::with(['model'])->where('address', $address)->where('type', Nft::class)
            ->orderByDesc('created_at')->firstOrFail();

        return new TxResource($tx);
    }

    protected function mintAddressFromLucid()
    {
        $seed = file_get_contents('/data/nfts/lido-minute/wallets/mint/seed.txt');
        try {
            return Http::post(
                config('cardano.lucidEndpoint').'/wallet/address',
                compact('seed')
            )->throw()->object();
        } catch (Exception $e) {
            dd($e);

            return null;
        }
    }
}
