<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class TagFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->unique()->words(rand(1, 3), true),
            'meta_title' => $this->faker->words(5, true),
            'slug' => fn (array $attributes) => Str::slug($attributes['title']),
            'content' => $this->faker->paragraphs(rand(5, 14), true),
        ];
    }
}
