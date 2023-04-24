<?php

namespace Database\Factories;

use App\Models\Assessment;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Assessor>
 */
class AssessmentFactory extends Factory
{
    protected $model = Assessment::class;

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
            'content' => $this->faker->paragraphs(rand(5, 18), true),
            'type' => 'App\Models\Comment',
        ];
    }
}
