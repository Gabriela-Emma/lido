<?php

namespace Database\Seeders;

use App\Models\Discussion;

class DiscussionSeeder extends PostSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Discussion::factory(48)
            ->hasRatings(rand(5, 55))
            ->create();
    }
}
