<?php

namespace Database\Seeders;

use App\Models\TwitterEvent;
use Illuminate\Database\Seeder;

class TwitterEventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TwitterEvent::factory(8)->create();
    }
}
