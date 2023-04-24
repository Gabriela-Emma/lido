<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\News;
use Illuminate\Database\Seeder;

class NewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        News::factory(4)
            ->has(Comment::factory()->count(2), 'comments')
            ->create();

        News::factory(2)
            ->create([
                'prologue' => null,
            ]);

        News::factory(1)
            ->create([
                'epilogue' => null,
            ]);
    }
}
