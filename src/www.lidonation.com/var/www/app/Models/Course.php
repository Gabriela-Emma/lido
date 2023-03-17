<?php

namespace App\Models;
use App\Models\Traits\HasHero;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    use HasFactory,
        HasHero,
        SoftDeletes;

    public function lessons()
    {
        //establish relationship of course to lessons
    }


}
