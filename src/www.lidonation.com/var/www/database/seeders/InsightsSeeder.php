<?php

namespace Database\Seeders;

use App\Models\Insight;

class InsightsSeeder extends PostSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Insight::factory(8)
            ->create();
    }
}
