<?php

namespace Database\Factories;

use App\Models\Translation;
use Illuminate\Database\Eloquent\Factories\Factory;

class TranslationFactory extends Factory
{
    protected $model = Translation::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'content' => '',
            'lang' => $this->faker->randomElement(['sw', 'zh', 'es']),
            'status' => $this->faker->randomElement(['draft', 'pending']),

        ];
    }
}
