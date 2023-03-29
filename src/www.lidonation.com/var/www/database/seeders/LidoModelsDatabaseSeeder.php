<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class LidoModelsDatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            CategorySeeder::class,
            LinkSeeder::class,
            TagSeeder::class,
            ArticlesSeeder::class,
            TeamSeeder::class
        ]);
    }
}
