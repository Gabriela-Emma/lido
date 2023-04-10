<?php

namespace Database\Factories;

use App\Models\Insight;
use App\Models\LearningLesson;
use App\Models\News;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<LearningLesson>
 */
class LearningLessonFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $model = $this->faker->randomElement([Insight::class, News::class]);
        return [
            'user_id' => fn () => User::inRandomOrder()->first()->id,
            'model_id' => $model::inRandomOrder()->first()->id,
            'model_type' => $model,
            'title' => $this->faker->words(4, true),
            'content' => $this->faker->paragraph(rand(2, 5), true),
            'difficulty' => $this->faker->randomElement(['beginner', 'beginner', 'advance', 'intermediate']),
            'number' => $this->faker->numberBetween(1, 14),
            'length' => $this->faker->numberBetween(240, 900),
            'status' => $this->faker->randomElement(['published', 'draft', 'published', 'published']),
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now')
        ];
    }
}
