<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Repo extends Model
{
   protected $table = 'repos';
   protected $guarded = [];

   public function commits(): HasMany
   {
     return $this->HasMany(Commits::class,'repo_id');
   }
}
