<?php

namespace App\Enums;

enum StatusEnum: string
{
    use Traits\HasValues;

    case DRAFT = 'draft';
    case PENDING = 'pending';
    case ACCEPTED = 'accepted';

<<<<<<< HEAD
    case SCHEDULE = 'scheduled';

    case PUBLISHED = 'published';
}
=======
    case PUBLISHED = 'published';
}
>>>>>>> d5126a654fefbe1f0b7dd7cdbc20c325300c22f8
