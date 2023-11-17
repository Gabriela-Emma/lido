<?php

namespace App\Http\Integrations\Fathom;

use Saloon\Http\Connector;

class FathomConnector extends Connector
{
    /**
     * Constructor
     */
    public function __construct()
    {
        if (config('services.fathom.key')) {
            $this->withTokenAuth(config('services.fathom.key'));
        }
    }

    public function resolveBaseUrl(): string
    {
        return 'https://api.usefathom.com/v1';
    }
}
