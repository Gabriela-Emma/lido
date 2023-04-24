<?php

namespace Database\Factories;

use App\Models\Tx;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tx>
 */
class TxFactory extends Factory
{
    protected $model = Tx::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'hash' => '8d99113bc46a65d41765bf57f7e0e6ce1b4771308930ab73a2d6f86e'.$this->faker->unique()->word(8),
            'status' => $this->faker->randomElement(['published', 'draft', 'minting', 'minted', 'published', 'blacklisted']),
        ];
    }
}
