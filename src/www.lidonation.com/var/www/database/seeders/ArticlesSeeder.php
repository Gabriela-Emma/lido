<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ArticlesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call([
            PostSeeder::class,
            InsightsSeeder::class,
            ReviewsSeeder::class,
        ]);
    }
}
