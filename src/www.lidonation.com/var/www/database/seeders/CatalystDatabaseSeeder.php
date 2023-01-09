<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CatalystDatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            FundSeeder::class,
            ProposalSeeder::class,
        ]);
    }
}
