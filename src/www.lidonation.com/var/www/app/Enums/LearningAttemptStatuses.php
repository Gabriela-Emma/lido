<?php

namespace App\Enums;

enum LearningAttemptStatuses: string
{
    use Traits\HasValues;

    case STARTED = 'started';

    case COMPLETED = 'completed';
}
