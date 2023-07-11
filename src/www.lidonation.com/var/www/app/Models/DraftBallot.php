<?php

namespace App\Models;

use App\Http\Traits\HasHashIds;
use App\Models\BookmarkCollection as ModelsBookmarkCollection;
use App\Models\Traits\HasAuthor;
use App\Models\Traits\HashIdModel;
use Illuminate\Database\Eloquent\SoftDeletes;

use Parental\HasParent;

class DraftBallot extends ModelsBookmarkCollection
{
    use HasAuthor, HasHashIds, HashIdModel, HasParent, SoftDeletes;



}
