<?php

namespace Database\Seeders;

use App\Models\Discussion;
use App\Models\Review;
use Illuminate\Database\Seeder;

class ReviewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Review::factory(5)
            ->has(
                Discussion::factory()
                    ->count(5)
                    ->state(function (array $attributes, Review $review) {
                        return [
                            'model_id' => $review->id,
                            'model_type' => $review->type,
                            'status' => 'published',
                        ];
                    })
            )
            ->create();
    }
}
