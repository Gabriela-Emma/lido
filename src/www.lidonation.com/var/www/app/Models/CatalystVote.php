<?php

namespace App\Models;

use App\Http\Traits\HasHashIds;
use App\Models\Traits\HasAuthor;
use App\Models\Traits\HashIdModel;
use App\Models\Traits\HasModel;

class CatalystVote extends Model
{
    use HasAuthor, HasModel, HasHashIds, HashIdModel;

    public function __invoke()
    {
        return $this->content;
    }

    public function __toString()
    {
        return $this->content;
    }
}
