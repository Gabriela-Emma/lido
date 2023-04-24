<?php

namespace Database\Seeders;

use App\Models\BookmarkItem;
use Illuminate\Database\Seeder;

class BookmarkItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        BookmarkItem::factory(4)->create();
    }
}
