<?php

namespace Database\Seeders;

use App\Models\ExternalPost;

class ExternalPostSeeder extends PostSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ExternalPost::factory(8)
            ->create();

    }
}
