<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class SnippetFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            // 'user_id' => fn () => LidoUser::inRandomOrder()->first()->id,
            // 'name' => $this->faker->unique()->words(rand(1, 9), true),
            // 'status' => $this->faker->randomElement(['published', 'draft', 'published', 'pending', 'published']),
            // 'content' => $this->faker->paragraphs(rand(5, 14), true),
            // 'order' => $this->faker->randomElement([null, 1, 2, null, 3, null, null, 4, null, null, 5]),
        ];
    }
}
