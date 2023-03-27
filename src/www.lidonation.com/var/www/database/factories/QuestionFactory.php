<?php

namespace Database\Factories;

use App\Models\Question;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Question>
 */
class QuestionFactory extends Factory
{
    protected $model = Question::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id' => fn () => User::inRandomOrder()->first()->id,
            'title' => $this->faker->words(4, true),
            'content' => $this->faker->sentence(rand(2, 3), true),
            'type' => $this->faker->randomElement(['general', 'technical', 'dev']),
            'status' => $this->faker->randomElement(['published', 'draft', 'published', 'pending', 'published']),
            'created_at' => now(),
        ];
    }
}
