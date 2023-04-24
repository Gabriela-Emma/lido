<?php

namespace Database\Factories;

use App\Models\Question;
use App\Models\Quiz;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Quiz>
 */
class QuizFactory extends Factory
{
    protected $model = Quiz::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id' => User::inRandomOrder()->first()->id,
            'title' => $this->faker->words(4, true),
            'content' => $this->faker->paragraphs(rand(5, 18), true),
            'status' => $this->faker->randomElement(['published', 'draft', 'published', 'pending', 'published']),
        ];
    }

    /**
     * Configure the model factory.
     *
     * @return $this
     */
    public function configure(): static
    {
        return $this->afterCreating(function (Quiz $quiz) {

            // $quiz->addMediaFromBase64($this->getImageUrl())
            //     ->toMediaCollection('hero');

            $quiz->questions()->attach(
                Question::inRandomOrder()
                    ->limit(random_int(1, 2))
                    ->pluck('id')
            );
        });
    }
}
