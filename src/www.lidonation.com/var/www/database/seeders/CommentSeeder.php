<?php

namespace Database\Seeders;

use App\Models\LegacyComment;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        LegacyComment::factory(215)
            ->create();
    }
}
