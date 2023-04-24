<?php

namespace App\Invokables;

use App\Models\Nft;
use App\Models\Tx;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class MintNft
{
    public function __invoke(Tx|int $tx): ?string
    {
        if (! $tx instanceof Tx) {
            $tx = Tx::where('hash', $this->hash)->firstOrFail();
        }

        if (! in_array($tx->status, ['paid', 'minting'])) {
            return null;
        }

        $nft = $tx->model;

        if (! $nft instanceof Nft) {
            throw new ModelNotFoundException('Related NFT not found.');
        }

        $seed = file_get_contents('/data/nfts/lido-minute/wallets/mint/seed.txt');
        $metadata = array_merge($nft->metadata?->toArray() ?? [], [
            'name' => 'A Day at the Lake: '.$nft->name.' #'.($nft->model->minted_nfts),
            'image' => $nft->storage_link,
            'series' => 'A Day at the Lake',
            'factoid' => breakLongText($nft->description, 44, 44, ' '),
            'homepage' => 'lidonation.com',
            'artist' => $nft->artist->name,
            'files' => [
                [
                    'src' => $nft->storage_link,
                    'name' => $nft->name,
                    'mediaType' => 'image/jpg',
                ],
            ],
        ]);
        $nft = [
            'key' => Str::remove(' ', $nft->name).($nft->model->minted_nfts),
            'owner' => $tx->address,
            'qty' => 1,
            'metadata' => $metadata,
        ];

        $res = Http::post(
            config('cardano.lucidEndpoint').'/lido-minute/mint',
            compact('nft', 'seed')
        )->throw();

        if ($res->status() > 201) {
            throw new Exception($res->body());
        }

        return $res->object()?->hash;
    }
}
