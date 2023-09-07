<?php

namespace App\Enums;

use Spatie\Enum\Enum;

final class CatalystCurrencyEnum extends Enum
{
    const USD = 'USD';

    const ADA = 'ADA';

    public static function values(): array
    {
        return [
            self::USD,
            self::ADA,
        ];
    }
}
