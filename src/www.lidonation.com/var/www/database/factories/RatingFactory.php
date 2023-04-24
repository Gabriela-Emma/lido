<?php

namespace Database\Factories;

use App\Models\Assessment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class RatingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $model = Post::inRandomOrder()->first();

        return [
            'user_id' => fn () => User::inRandomOrder()->first()->id,
            'comment_id' => fn () => Assessment::factory()->create(['model_type' => $model->type, 'model_id' => $model->id]),
            'model_id' => fn () => $model->id,
            'model_type' => fn () => $model->type,
            'rating' => $this->faker->numberBetween(1, 5),
            'status' => $this->faker->randomElement(['published', 'draft', 'published', 'pending', 'published']),
            'created_at' => $this->faker->dateTimeBetween('-2 Years'),
        ];
    }
}
