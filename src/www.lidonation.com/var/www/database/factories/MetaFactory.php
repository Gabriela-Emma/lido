<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use JetBrains\PhpStorm\ArrayShape;

class MetaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     *
     * @throws \Exception
     */
    #[ArrayShape(['key' => 'string', 'content' => 'array|string'])]
    public function definition(): array
    {
        return [
            'key' => $this->faker->word(),
            'content' => $this->faker->words(random_int(2, 5), true),
        ];
    }
}
