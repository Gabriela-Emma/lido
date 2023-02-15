<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;

class AuthenticateCatalystUser extends Authenticate
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  Request  $request
     * @return string|null
     */
    protected function redirectTo($request): ?string
    {
        if (! $request->expectsJson()) {
            return route('catalystExplorer.login');
        }
    }
}