<?php

namespace App\Services;

use App\Http\Integrations\Blockfrost\Requests\BlockfrostRequest;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;

class CardanoBlockfrostService
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
    * @return $response -> response is an object
    */
    public function request($method, $relativePath, $data = [])
    {
        return $this->getClient()->{$method}($relativePath, $data);
    }

    /**
     * @todo implement method support parallel requests
     */
    public function requests(): void
    {
    }

    /**
     * Method called automatically on instantiation and sets base variables for blockfrost interactions
     * Variables set are -> $blockfrostUrl, $projectId and $poolId
     */
    private function init(): void
    {
        $this->poolId = config('cardano.pool.hash');
        $envBlockfrost = config('services.blockfrost');
        $this->projectId = $envBlockfrost['projectId'];
        $this->blockfrostUrl = $envBlockfrost['baseUrl'];
    }

    protected function getClient(): PendingRequest
    {
        return Http::withHeaders([
            'project_id' => $this->projectId,
        ])->baseUrl($this->blockfrostUrl);
    }

    public static function queryBlockFrost(string $endpoint)
    {
        $blockfrostReq = new BlockfrostRequest($endpoint);
        $response = $blockfrostReq->send();

        return $response->json();
    }
}
