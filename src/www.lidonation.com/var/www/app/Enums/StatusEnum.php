<?php

namespace App\Enums;

enum StatusEnum: string
{
    use Traits\HasValues;

    case DRAFT = 'draft';
    case PENDING = 'pending';
    case ACCEPTED = 'accepted';

    case SCHEDULE = 'scheduled';

    case PUBLISHED = 'published';
}

