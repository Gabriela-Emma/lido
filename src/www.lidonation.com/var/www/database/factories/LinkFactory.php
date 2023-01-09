<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class LinkFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'label' => $this->faker->unique()->words(rand(1, 4), true),
            'title' => $this->faker->unique()->words(rand(1, 9), true),
            'link' => $this->faker->unique()->url(),
            'status' => $this->faker->randomElement(['published', 'draft', 'published', 'pending', 'published']),
            'valid' => $this->faker->randomElement([1, 1, 1, 0, 1, 1, null, 0, 0, 1, 1, 1, 1]),
            'order' => $this->faker->randomElement([null, 1, 2, null, 3, null, null, 4, null, null, 5]),
        ];
    }
}
