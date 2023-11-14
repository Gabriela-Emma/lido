<?php

namespace App\Http\Integrations\Fathom\Requests;

use Carbon\Carbon;
use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetCatalystQueries extends Request
{
    protected Method $method = Method::GET;

    public function __construct(protected string $eventId, protected int $days)
    {

    }

    public function resolveEndpoint(): string
    {
        return '/aggregations';
    }

    protected function defaultQuery(): array
    {
        return [
            'entity' => 'event',
            'entity_id' => $this->eventId,
            'aggregates' => 'conversions',
            'date_from' => Carbon::today()->subDays($this->days)->toDateTimeString(),
            'date_to' => Carbon::today()->toDateTimeString(),
        ];
    }
}
