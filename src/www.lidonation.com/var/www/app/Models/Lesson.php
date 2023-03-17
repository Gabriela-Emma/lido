<?php

namespace App\Models;

use App\Models\Post;
use App\Models\User;
use App\Models\Course;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Lesson extends Model
{
    use HasFactory;

    public function article()
    {
        return $this->belongsToMany(Post::class, 'lesson_post');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
