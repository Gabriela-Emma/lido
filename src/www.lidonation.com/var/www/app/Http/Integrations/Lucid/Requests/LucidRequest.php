<?php

namespace App\Http\Integrations\Lucid\Requests;

use App\Http\Integrations\Lucid\LucidConnector;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Connector;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;
use Saloon\Traits\Request\HasConnector;

class LucidRequest extends Request implements HasBody
{
    use HasConnector, HasJsonBody;

    protected Method $method = Method::POST;

    public function __construct(
        protected string $endpoint,
        protected ?string $seed,

    ) {
    }

    public function resolveConnector(): Connector
    {
        return app(LucidConnector::class);
    }

    public function resolveEndpoint(): string
    {
        return $this->endpoint;
    }

    public function defaultBody(): array
    {
        return [
            'seed' => $this->seed,
        ];
    }
}
