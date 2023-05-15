<?php

namespace App\Nova\Dashboards;

use Laravel\Nova\Cards\Help;
use Laravel\Nova\Dashboards\Main as Dashboard;

class Main extends Dashboard
{
    /**
     * Get the URI key of the dashboard.
     *
     * @return string
     */
    public function uriKey(): string
    {
        return 'main';
    }

    /**
     * Get the cards for the dashboard.
     *
     * @return array
     */
    public function cards(): array
    {
        return [
            // new Help,
        ];
    }
}
