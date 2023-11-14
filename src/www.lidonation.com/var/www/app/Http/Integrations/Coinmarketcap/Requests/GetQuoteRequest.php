<?php

// namespace App\Http\Integrations\AdaQuote\Requests;

namespace App\Http\Integrations\Coinmarketcap\Requests;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetQuoteRequest extends Request
{
    /**
     * The HTTP method of the request
     */
    protected Method $method = Method::GET;

    public function __construct(protected int $id)
    {

    }

    /**
     * The endpoint for the request
     */
    public function resolveEndpoint(): string
    {
        return '/v2/cryptocurrency/quotes/latest';
    }

    protected function defaultQuery(): array
    {
        return [
            'id' => $this->id,
        ];
    }
}
