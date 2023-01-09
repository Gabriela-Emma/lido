<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Spatie\RobotsMiddleware\RobotsMiddleware as SpatieRobotsMiddleware;

class RobotsMiddleware extends SpatieRobotsMiddleware
{
    /**
     * @return string|bool
     */
    protected function shouldIndex(Request $request): bool|string
    {
        if (! Str::contains(config('app.url'), 'www.lidonation.com')) {
            return 'noindex';
        }

        if (collect([
            'admin',
            'voltaire',
        ])->contains($request->segment(1))) {
            return 'noindex';
        }

        return 'all';
    }
}
