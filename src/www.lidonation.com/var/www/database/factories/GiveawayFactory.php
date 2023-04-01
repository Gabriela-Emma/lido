<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Giveaway>
 */
class GiveawayFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            "user_id" => fn () => User::inRandomOrder()->first()->id,
            "title" => $this->faker->words(4, true),
            "meta_title" => $this->faker->words(6, true),
            "status" => $this->faker->randomElement(['Published', 'draft', 'pending', 'Ready', 'Schedule']),
            'social_excerpt' => $this->faker->sentences(rand(2, 3), true),
            'content' => $this->faker->paragraphs(rand(4, 8), true), 
        ];
    }
}
