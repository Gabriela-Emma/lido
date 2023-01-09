<?php

namespace App\Nova\Dashboards;

use JetBrains\PhpStorm\Pure;
use Laravel\Nova\Cards\Help;
use Laravel\Nova\Dashboards\Main as Dashboard;

class Main extends Dashboard
{
    /**
     * Get the cards for the dashboard.
     *
     * @return array
     */
    #[Pure]
    public function cards()
    {
        return [
            new Help,
        ];
    }
}
