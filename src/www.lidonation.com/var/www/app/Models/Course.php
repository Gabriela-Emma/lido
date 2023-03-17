<?php

namespace App\Models;

use App\Models\Lesson;
use App\Models\Traits\HasHero;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Course extends Model
{
    use HasFactory,
        HasHero,
        SoftDeletes;

    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }


}
