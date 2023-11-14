<?php

namespace App\Models;

use App\Models\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Prunable;

class AnonymousBookmark extends Model
{
    use Prunable, UsesUuid;

    protected $fillable = ['bookmark', 'created_at', 'updated_at'];
}
