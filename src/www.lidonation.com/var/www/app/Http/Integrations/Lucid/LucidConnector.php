<?php

namespace App\Http\Integrations\Lucid;

use Saloon\Http\Connector;

class LucidConnector extends Connector
{
    public function resolveBaseUrl(): string
    {
        return config('services.lucid.url');
    }

    protected function defaultHeaders(): array
    {
        return [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ];
    }

    protected function defaultQuery(): array
    {
        return [];
    }
}
