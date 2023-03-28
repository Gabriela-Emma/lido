<?php

namespace Database\Factories;

use App\models\Question;
use App\models\QuestionAnswer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\QuestionAnswer>
 */
class QuestionAnswerFactory extends Factory
{
    protected $model = QuestionAnswer::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'question_id' => fn () => Question::inRandomOrder()->first()->id,
            'status' => $this->faker->randomElement(['published', 'draft', 'published', 'pending', 'published']),
            'correctness' => $this->faker->randomElement(['true', 'false']),
            'hint' => $this->faker->sentence(rand(2, 3), true),
            'created_at' => now(),
            'content' => $this->faker->sentence(rand(2, 3), true),
        ];
    }
}
