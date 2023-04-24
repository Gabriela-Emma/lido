<?php

namespace Database\Factories;

use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    protected $model = Event::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->sentence(rand(2, 4), true),
            'content' => $this->faker->sentence(rand(5, 10), true),
            'starts_at' => $this->faker->dateTimeBetween('+0 days', '+2 years'),
        ];
    }
}
