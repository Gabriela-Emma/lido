<?php

namespace Database\Factories;

use App\Models\CatalystUser;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CatalystUser>
 */
class CatalystUserFactory extends Factory
{
    protected $model = CatalystUser::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->unique()->name,
            'email' => $this->faker->email,
            'bio'=>$this->faker->sentence(rand(2, 3), true),
            'created_at' => now(),
        ];
    }
}
