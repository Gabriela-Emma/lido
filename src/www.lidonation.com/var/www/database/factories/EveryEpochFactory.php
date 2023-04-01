<?php

namespace Database\Factories;

use App\Models\EveryEpoch;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\EveryEpoch>
 */
class EveryEpochFactory extends Factory
{
    protected $model = EveryEpoch::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id' => fn () => User::inRandomOrder()->first()->id,
            'epoch' => $this->faker->numberBetween(0, 500), 
            'title' => $this->faker->words(4, true),
            'content' => $this->faker->paragraph(rand(2, 5), true),
            'status' => $this->faker->randomElement(['published', 'draft', 'published', 'pending', 'published']),
        ];
    }
}
