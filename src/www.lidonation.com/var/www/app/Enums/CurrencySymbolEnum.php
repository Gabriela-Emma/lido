<?php

namespace App\Enums;

use Spatie\Enum\Enum;

final class CurrencySymbolEnum extends Enum
{
    const USD = '$';

    const ADA = '₳';

    public static function values(): array
    {
        return [
            self::USD,
            self::ADA,
        ];
    }
}
