<?php

namespace Database\Seeders;

use App\Models\LearningLesson;
use Illuminate\Database\Seeder;

class LearningLessonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LearningLesson::factory(12)->create();
    }
}
