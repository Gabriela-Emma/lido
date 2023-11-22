<?php

namespace App\Enums;

enum ContributionStatusEnum: string
{
    use Traits\HasValues;

    case AVAILAVLE = 'available';
    case CLAIMED = 'claimed';
    case COMPLETED = 'completed';
    case EXPIRED = 'expired';

}
