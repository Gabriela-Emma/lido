<?php

namespace App\Http\Integrations\Fathom\Requests;

use Carbon\Carbon;
use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetPageViews extends Request
{
    protected Method $method = Method::GET;

    public function __construct(protected int $days)
    {

    }

    public function resolveEndpoint(): string
    {
        return '/aggregations';
    }

    protected function defaultQuery(): array
    {
        return [
            'entity' => 'pageview',
            'entity_id' => config('services.fathom.site'),
            'aggregates' => 'pageviews',
            'date_from' => Carbon::today()->subDays($this->days)->toDateTimeString(),
            'date_to' => Carbon::today()->toDateTimeString(),
        ];
    }
}
