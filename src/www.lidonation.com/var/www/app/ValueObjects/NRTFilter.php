<?php

namespace App\ValueObjects;

use Illuminate\Contracts\Support\Arrayable;

final class NRTFilter implements Arrayable, \JsonSerializable
{
    public string $subject;

    public function toArray(): array
    {
        return get_object_vars($this);
    }

    public function jsonSerialize(): string
    {
        return json_encode($this);
    }
}
