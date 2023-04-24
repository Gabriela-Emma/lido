<?php

namespace Database\Factories;

use App\Models\Assessor;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Assessor>
 */
class AssessorFactory extends Factory
{
    protected $model = Assessor::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'assessor_id' => User::inRandomOrder()->first()->id,
        ];
    }
}
