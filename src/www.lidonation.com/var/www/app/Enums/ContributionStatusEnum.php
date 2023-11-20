<?php

namespace App\Enums;

use Spatie\Enum\Enum;

enum ContributionStatusEnum : string
{
    use Traits\HasValues;

    case AVAILAVLE = 'available';
    case CLAIMED = 'claimed';
    case COMPLETED = 'completed';
    case EXPIRED = 'expired';

}


