<?php

namespace App\Models;

use App\Http\Traits\HasHashIds;
use App\Models\Traits\HashIdModel;

use Parental\HasParent;

class DraftBallot extends BookmarkCollection
{
    use HasHashIds, HashIdModel, HasParent;

    protected $urlGroup = 'catalyst-explorer/draft-ballots';

}
