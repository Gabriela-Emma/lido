<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class LidoEarnLearnDatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            LearningModulesSeeder::class,
            LearningTopicSeeder::class,
            LearningLessonSeeder::class,
        ]);
    }
}
