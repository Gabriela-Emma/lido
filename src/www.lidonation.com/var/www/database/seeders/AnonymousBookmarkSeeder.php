<?php

namespace Database\Seeders;

use App\Models\AnonymousBookmark;
use Illuminate\Database\Seeder;

class AnonymousBookmarkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AnonymousBookmark::factory(10)->create([]);
    }
}
