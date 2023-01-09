<?php

namespace App\Traits;

use Closure;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Arr;

trait HasRemovableGlobalScopes
{
    /**
     * @param  Scope|string  $scope
     */
    public static function withoutGlobalScope(Scope|string $scope)
    {
        if (is_string($scope) && isset(static::$globalScopes[static::class]) && is_array(static::$globalScopes[static::class])) {
            Arr::forget(static::$globalScopes[static::class], $scope);
        } elseif ($scope instanceof Closure) {
            Arr::forget(static::$globalScopes[static::class], spl_object_hash($scope));
        } elseif ($scope instanceof Scope) {
            Arr::forget(static::$globalScopes[static::class], get_class($scope));
        }
    }

    /**
     * @param  Scope[]|string[]  $scopes
     */
    public static function withoutGlobalScopes(array $scopes = [])
    {
        if (empty($scopes)) {
            static::$globalScopes = [];
        } else {
            foreach ($scopes as $scope) {
                static::withoutGlobalScope($scope);
            }
        }
    }
}
