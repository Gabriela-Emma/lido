<?php

namespace Database\Factories;

use App\Models\CatalystExplorer\Group;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CatalystExplorer\Group>
 */
class CatalystGroupFactory extends Factory
{
    protected $model = Group::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->words(rand(1, 3), true),
            'slug' => fn (array $attributes) => Str::slug($attributes['name']),
            'bio' => $this->faker->sentence(10, 15),
            'status' => $this->faker->randomElement(['published', 'draft', 'published', 'pending', 'published']),
        ];
    }
}
