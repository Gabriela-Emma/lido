<?php

namespace App\Http\Integrations\Blockfrost;

use Saloon\Contracts\Authenticator;
use Saloon\Http\Auth\QueryAuthenticator;
use Saloon\Http\Connector;

class BlockfrostConnector extends Connector
{
    public function resolveBaseUrl(): string
    {
        return config('services.blockfrost.baseUrl');
    }

    protected function defaultHeaders(): array
    {
        return [
            // 'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'project_id' => config('services.blockfrost.projectId'),
        ];
    }

    protected function defaultQuery(): array
    {
        return [];
    }

    protected function defaultAuth(): ?Authenticator
    {
        return new QueryAuthenticator(
            'project_id',
            config('services.blockfrost.projectId'),
        );
    }
}
