<?php

namespace Database\Factories;

use App\Models\Rule;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Rule>
 */
class RuleFactory extends Factory
{
    protected $model = Rule::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'subject' => $this->faker->words(5, true),
            'operator' => $this->faker->randomElement(['lt', 'lte', 'eq', 'gt', 'gte']),
            'predicate' => $this->faker->words(5, true),
            'context' => $this->faker->words(rand(6, 8), true),
            'apply_with' => $this->faker->randomElement(['and', 'or']),
            'status' => $this->faker->randomElement(['published', 'draft', 'pending', 'ready', 'scheduled']),
            'type' => $this->faker->randomElement(['custom', 'model', 'pool', 'epoch', 'sheduled']),
        ];
    }
}
