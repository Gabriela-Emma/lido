<?php

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use InvalidArgumentException;

class NRTFilter implements CastsAttributes
{
    public function get($model, string $key, $value, array $attributes): \App\ValueObjects\NRTFilter
    {
        return new \App\ValueObjects\NRTFilter(
            $attributes['subject']
        );
    }

    public function set($model, string $key, $value, array $attributes): array
    {
        if (! $value instanceof \App\ValueObjects\NRTFilter) {
            throw new InvalidArgumentException('The given value is not an NRTFilter value object instance.');
        }

        return [
            'subject' => $value->subject,
        ];
    }
}
