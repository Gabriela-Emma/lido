<?php

namespace App\Enums;

enum StatusEnum: string
{
    use Traits\HasValues;

    case DRAFT = 'draft';
    case PENDING = 'pending';
    case ACCEPTED = 'accepted';
    case AVAILAVLE = 'available';
    case CLAIMED = 'claimed';
    case COMPLETED = 'completed';
    case EXPIRED = 'expired';
}
