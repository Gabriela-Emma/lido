<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ArticlesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $this->call([
            PostSeeder::class,
            NewsSeeder::class,
            InsightsSeeder::class,
            ReviewsSeeder::class
        ]);
    }
}
