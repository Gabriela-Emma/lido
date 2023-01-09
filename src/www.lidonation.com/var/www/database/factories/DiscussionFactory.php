<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class DiscussionFactory extends Factory
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
            'model_id' => fn () => $model->id,
            'model_type' => fn () => $model->type,
            'title' => $this->faker->words(rand(1, 3), true),
            'status' => $this->faker->randomElement(['published', 'draft', 'published', 'pending', 'published']),
            'content' => $this->faker->paragraphs(rand(1, 4), true),
            'created_at' => $this->faker->dateTimeBetween('-2 Years'),
            'published_at' => $this->faker->dateTimeBetween('-1 Years'),
            'order' => $this->faker->randomElement([null, 1, 2, null, 3, null, null, 4, null, null, 5]),
        ];
    }
}
