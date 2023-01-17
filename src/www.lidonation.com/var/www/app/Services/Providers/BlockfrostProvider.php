<?php

namespace App\Services\Providers;

use App\Contracts\ProvidesCardanoService;
use App\Models\User;
use GuzzleHttp\Middleware;
use Http\Factory\Guzzle\StreamFactory;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use JsonMachine\Items;
use Psr\Http\Message\ResponseInterface;

class BlockfrostProvider implements ProvidesCardanoService
{
    protected string $blockfrostUrl;

    protected string $projectId;

    protected string $poolId;

    public function __construct()
    {
        $this->init();
    }

    public function __call($verb, $args)
    {
        [$path, $data] = $args;

        return $this->request($verb, $path, $data);
    }

    /*
    * Method that allows calls to blockfrost endpoints
    *
    * @param $method -> HTTP methods get, post, put, delete
    * @param $relativePath -> relative path to endpoint
    * @param $data -> an array to hold data that we pass to endpoint
    *
    * @return $response -> response is an obje$ct
    */
    public function request($method, $relativePath, $data = [])
    {
        return $this->getClient()->{$method}($relativePath, $data);
    }

    /**
     * @return void
     *
     * @todo implement method support parallel requests
     */
    public function requests(): void
    {
    }

    public function account(string|User $account, string $detail = ''): Response
    {
        $stakeAddress = $account?->wallet_stake_address ?? $account;

        return $this->getClient()
            ->get("/accounts/{$stakeAddress}/{$detail}", ['order' => 'desc', 'count' => 100]);
    }

    public function tx(string $hash = ''): Response
    {
        return $this->getClient(false)->get("/txs/{$hash}");
    }

    protected function getClient($collect = true): PendingRequest
    {
        return  Http::withHeaders([
            'project_id' => $this->projectId,
        ])->baseUrl(config('services.blockfrost.baseUrl'))
            ->accept('application/json')
            ->retry(1, 500)
            ->withMiddleware(
                Middleware::mapResponse(function (ResponseInterface $response) use ($collect) {
                    if (! $collect) {
                        return $response;
                    }

                    $data = collect(Items::fromString($response->getBody()->getContents()));
                    if ($data->isEmpty()) {
                        return $response;
                    }
                    $data = $data->map(function ($item) {
                        return collect((array) $item)
                            ->mapWithKeys(fn ($value, $key) => [Str::camel($key) => $value])
                            ->toArray();
                    });

                    return $response->withBody(
                        (new StreamFactory)
                            ->createStream($data->toJson())
                    );
                }));
    }

    /**
     * Method called automatically on instantiation and sets base variables for blockfrost interactions
     * Variables set are -> $blockfrostUrl, $projectId and $poolId
     */
    private function init()
    {
        $this->poolId = config('cardano.pool.hash');
        $envBlockfrost = config('services.blockfrost');
        $this->projectId = $envBlockfrost['projectId'];
        $this->blockfrostUrl = $envBlockfrost['baseUrl'];
    }
}
