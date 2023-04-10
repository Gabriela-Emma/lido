<?php

namespace Database\Factories;

use App\Models\LearningTopic;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<LearningTopic>
 */
class LearningTopicFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => fn () => User::inRandomOrder()->first()->id,
            'title' => $this->faker->words(4, true),
            'content' => $this->faker->paragraph(rand(5, 8), true),
            'difficulty' => $this->faker->randomElement(['beginner', 'beginner', 'advance', 'intermediate']),
            'status' => $this->faker->randomElement(['published', 'draft', 'published', 'published']),
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now')
        ];
    }
}
