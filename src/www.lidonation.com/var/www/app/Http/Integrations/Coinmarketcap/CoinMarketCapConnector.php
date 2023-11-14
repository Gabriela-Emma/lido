<?php

// namespace App\Http\Integrations;

namespace App\Http\Integrations\Coinmarketcap;

use Saloon\Http\Connector;

class CoinMarketCapConnector extends Connector
{
    /**
     * Constructor
     *
     * @param  string  $apiKey
     */
    public function resolveBaseUrl(): string
    {
        return 'https://pro-api.coinmarketcap.com';
    }

    public function defaultHeaders(): array
    {
        return [
            'X-CMC_PRO_API_KEY' => config('services.coinmarketcap.key'),
            'Accepts' => 'application/json',
        ];
    }
}
