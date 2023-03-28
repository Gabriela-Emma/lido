<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Insight;
use Illuminate\Database\Seeder;

class InsightsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Insight::factory(10)
            ->has(Comment::factory()->count(2), 'comments')
            ->create();
    }
}
